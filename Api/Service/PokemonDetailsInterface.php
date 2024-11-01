<?php

/**
 * File: PokemonDetailsInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Service;

use Magento\Catalog\Api\Data\ProductInterface;

interface PokemonDetailsInterface
{
    /**
     * Get pokemon details.
     *
     * @param  ProductInterface $product
     * @return array
     */
    public function getPokemonDetails(ProductInterface $product): array;
}
