<?php
/**
 * File: PokemonApi.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Api\Client;

use Exception;
use Juszczyk\PokemonProduct\Model\Api\CacheHandler;
use Juszczyk\PokemonProduct\Model\ConfigProvider;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;

class PokemonApi
{
    private const string POKEMON_DETAILS_ENDPOINT = "/pokemon/";

    private const int HTTP_STATUS_OK = 200;

    /**
     * PokemonApi class constructor.
     *
     * @param ConfigProvider $configProvider
     * @param Curl $curl
     * @param Json $json
     * @param CacheHandler $cacheHandler
     */
    public function __construct(
        private readonly ConfigProvider $configProvider,
        private readonly Curl $curl,
        private readonly Json $json,
        private readonly CacheHandler $cacheHandler
    ) {
    }

    /**
     * Get pokemon details based on product.
     *
     * @param ProductInterface $product
     * @return array
     * @throws Exception
     */
    public function getPokemonDetails(ProductInterface $product): array
    {
        $pokemonName = $product->getPokemonName();
        $response = $this->cacheHandler->loadFromCache($product) ??
            $this->fetchAndCachePokemonDetails($pokemonName, $product);
        return $this->json->unserialize($response);
    }

    /**
     * Fetch and cache pokemon details.
     *
     * @param string $pokemonName
     * @param ProductInterface $product
     * @return string
     * @throws Exception
     */
    private function fetchAndCachePokemonDetails(string $pokemonName, ProductInterface $product): string
    {
        $response = $this->get($this->getPokemonDetailsUrl($pokemonName));
        $this->cacheHandler->saveToCache($response, $product);
        return $response;
    }

    /**
     * Get PokeAPI full URL for "pokemon" endpoint.
     *
     * @param  string $pokemonName
     * @return string
     */
    private function getPokemonDetailsUrl(string $pokemonName): string
    {
        return sprintf(
            "%s%s%s",
            rtrim($this->configProvider->getApiUrl(), "/"),
            self::POKEMON_DETAILS_ENDPOINT,
            strtolower($pokemonName)
        );
    }

    /**
     * Send GET request.
     *
     * @param string $url
     * @return string
     * @throws LocalizedException
     */
    private function get(string $url): string
    {
        $this->curl->get($url);
        if (($status = $this->curl->getStatus()) !== self::HTTP_STATUS_OK) {
            throw new LocalizedException(
                __("PokeAPI returned HTTP status code: %1 | %2", $status, $this->curl->getBody())
            );
        }
        return $this->curl->getBody();
    }
}
