<?php

/**
 * File: PokemonNameInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Service\PokemonDetails;

use Magento\Catalog\Api\Data\ProductInterface;

interface PokemonNameInterface
{
    /**
     * Get product name combined (or not) with pokemon name.
     *
     * @param ProductInterface $product
     * @return string
     */
    public function getProductName(ProductInterface $product): string;
}
