<?php

/**
 * File: PokemonImageInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Service\PokemonDetails;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\Image;

interface PokemonImageInterface
{
    /**
     * Get pokemon image to use on listing.
     *
     * @param ProductInterface $product
     * @param Image $productImage
     * @return Image
     */
    public function getPokemonListingImage(ProductInterface $product, Image $productImage): Image;

    /**
     * Get pokemon image URL.
     *
     * @param ProductInterface $product
     * @return string|null
     */
    public function getPokemonImageUrl(ProductInterface $product): ?string;

}
