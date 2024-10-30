<?php

/**
 * File: PokemonImage.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Service\PokemonDetails;

use Exception;
use Juszczyk\PokemonProduct\Api\Service\PokemonDetails\PokemonImageInterface;
use Juszczyk\PokemonProduct\Model\Service\PokemonDetails;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\Image;

class PokemonImage extends PokemonDetails implements PokemonImageInterface
{
    /**
     * @inheritDoc
     */
    public function getPokemonListingImage(ProductInterface $product, Image $productImage): Image
    {
        if (!$this->pokemonProductValidator->shouldUsePokemonDetails($product)) {
            return $productImage;
        }
        $pokemonImageUrl = $this->getPokemonImageUrl($product);
        if (! $pokemonImageUrl) {
            return $productImage;
        }
        $productImage->setImageUrl($pokemonImageUrl);
        return $productImage;
    }

    /**
     * @inheritDoc
     */
    public function getPokemonImageUrl(ProductInterface $product): ?string
    {
        try {
            if (!$this->pokemonProductValidator->shouldUsePokemonDetails($product)) {
                return null;
            }
            return $this->getPokemonDetails($product)['sprites']['other']['official-artwork']['front_default'] ?? null;
        } catch (Exception $exception) {
            $this->logHandler->logError($exception);
            $this->messageManager->addErrorMessage(
                __('An error occurred while retrieving the pokemon image. Please try again later or contact us.')
            );
            return null;
        }
    }
}
