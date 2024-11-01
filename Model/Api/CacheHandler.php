<?php

/**
 * File: CacheHandler.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Api;

use Juszczyk\PokemonProduct\Api\Api\CacheHandlerInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\CacheInterface;

class CacheHandler implements CacheHandlerInterface
{
    private const string POKEMON_PRODUCT_CACHE_TAG_PREFIX = "pokemon_product";

    /**
     * CacheHandler class constructor.
     *
     * @param CacheInterface $cache
     */
    public function __construct(protected readonly CacheInterface $cache)
    {
    }

    /**
     * @inheritDoc
     */
    public function loadFromCache(ProductInterface $product): ?string
    {
        return $this->cache->load($this->getCacheKey($product)) ?: null;
    }

    /**
     * @inheritDoc
     */
    public function saveToCache(string $response, ProductInterface $product): void
    {
        $this->cache->save(
            $response,
            $this->getCacheKey($product),
            $product->getIdentities()
        );
    }

    /**
     * Get PokeAPI response cache key: {pokemon_product_$productId}.
     *
     * @param  ProductInterface $product
     * @return string
     */
    private function getCacheKey(ProductInterface $product): string
    {
        return sprintf("%s_%s", self::POKEMON_PRODUCT_CACHE_TAG_PREFIX, $product->getId());
    }
}
