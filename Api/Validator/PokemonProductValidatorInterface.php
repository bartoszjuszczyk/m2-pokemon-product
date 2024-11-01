<?php

/**
 * File: PokemonProductValidatorInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Validator;

use Magento\Catalog\Api\Data\ProductInterface;

interface PokemonProductValidatorInterface
{
    /**
     * Determine if pokemon details should be used based on module configuration and product properties.
     *
     * @param  ProductInterface $product
     * @return bool
     */
    public function shouldUsePokemonDetails(ProductInterface $product): bool;
}
