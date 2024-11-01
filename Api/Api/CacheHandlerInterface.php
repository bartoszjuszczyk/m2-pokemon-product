<?php

/**
 * File: CacheHandlerInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface CacheHandlerInterface
{
    /**
     * Load PokeAPI response from cache.
     *
     * @param  ProductInterface $product
     * @return string|null
     */
    public function loadFromCache(ProductInterface $product): ?string;

    /**
     * Save PokeAPI response to cache.
     *
     * @param  string           $response
     * @param  ProductInterface $product
     * @return void
     */
    public function saveToCache(string $response, ProductInterface $product): void;
}
