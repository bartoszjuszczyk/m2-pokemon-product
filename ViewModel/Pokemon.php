<?php
/**
 * File: Pokemon.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\ViewModel;

use Juszczyk\PokemonProduct\Model\Service\PokemonDetails\PokemonImage;
use Juszczyk\PokemonProduct\Model\Service\PokemonDetails\PokemonName;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\Image;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Pokemon implements ArgumentInterface
{
    /**
     * Pokemon class constructor.
     *
     * @param PokemonImage $pokemonImageService
     * @param PokemonName $pokemonNameService
     */
    public function __construct(
        protected readonly PokemonImage $pokemonImageService,
        protected readonly PokemonName $pokemonNameService
    ) {
    }

    /**
     * Get product name combined (or not) with pokemon name.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getProductName(ProductInterface $product): string
    {
        return $this->pokemonNameService->getProductName($product);
    }

    /**
     * Get pokemon image to use on listing.
     *
     * @param ProductInterface $product
     * @param Image $productImage
     * @return Image
     */
    public function getPokemonListingImage(ProductInterface $product, Image $productImage): Image
    {
        return $this->pokemonImageService->getPokemonListingImage($product, $productImage);
    }

    /**
     * Get pokemon image URL.
     *
     * @param  ProductInterface $product
     * @return string|null
     */
    public function getPokemonImageUrl(ProductInterface $product): ?string
    {
        return $this->pokemonImageService->getPokemonImageUrl($product);
    }
}
