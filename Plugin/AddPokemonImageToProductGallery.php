<?php
/**
 * File: AddPokemonImageToProductGallery.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Plugin;

use Juszczyk\PokemonProduct\ViewModel\Pokemon;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\View\Gallery;
use Magento\Catalog\Helper\Data;
use Magento\Framework\Serialize\Serializer\Json;

class AddPokemonImageToProductGallery
{
    private const string POKEMON_IMAGE_CAPTION = 'Pokemon Image';

    /**
     * AddPokemonImageToProductGallery class constructor.
     *
     * @param Json    $json
     * @param Pokemon $pokemonViewModel
     * @param Data    $productDataHelper
     */
    public function __construct(
        protected readonly Json $json,
        protected readonly Pokemon $pokemonViewModel,
        protected readonly Data $productDataHelper
    ) {
    }

    /**
     * Add pokemon image to gallery images JSON.
     *
     * @param  Gallery $subject
     * @param  string  $result
     * @return string
     */
    public function afterGetGalleryImagesJson(Gallery $subject, string $result): string
    {
        $images = $this->json->unserialize($result);
        $lastImagePosition = $this->getLastImagePosition($images);
        $product = $this->getProduct();
        if (! $product || ! $product->hasPokemonName()) {
            return $result;
        }
        $pokemonImageUrl = $this->pokemonViewModel->getPokemonImageUrl($product);
        if (! $pokemonImageUrl) {
            return $result;
        }
        $images[] = [
            'thumb' => $pokemonImageUrl,
            'img' => $pokemonImageUrl,
            'full' => $pokemonImageUrl,
            'caption' => self::POKEMON_IMAGE_CAPTION,
            'position' => $lastImagePosition + 1,
            'isMain' => false,
            'type' => 'image',
            'videoUrl' => null
        ];

        return $this->json->serialize($images);
    }

    /**
     * Get current product.
     *
     * @return ProductInterface
     */
    protected function getProduct(): ProductInterface
    {
        return $this->productDataHelper->getProduct();
    }

    /**
     * Get last image position from original product gallery.
     *
     * @param  array $images
     * @return int
     */
    protected function getLastImagePosition(array $images): int
    {
        $position = 0;
        foreach ($images as $image) {
            if ($image['position'] && $image['position'] > $position) {
                $position = $image['position'];
            }
        }

        return (int) $position;
    }
}
