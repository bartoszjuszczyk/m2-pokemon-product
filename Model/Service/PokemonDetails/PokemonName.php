<?php

/**
 * File: PokemonName.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Service\PokemonDetails;

use Exception;
use Juszczyk\PokemonProduct\Api\Service\PokemonDetails\PokemonNameInterface;
use Juszczyk\PokemonProduct\Model\Service\PokemonDetails;
use Magento\Catalog\Api\Data\ProductInterface;

class PokemonName extends PokemonDetails implements PokemonNameInterface
{
    /**
     * @inheritDoc
     */
    public function getProductName(ProductInterface $product): string
    {
        $originalProductName = $product->getName();
        if (!$this->pokemonProductValidator->shouldUsePokemonDetails($product)) {
            return $originalProductName;
        }
        $pokemonName = $this->getPokemonNameFromApi($product);
        if (!$pokemonName) {
            return $originalProductName;
        }
        return sprintf("%s %s", $originalProductName, ucfirst($pokemonName));
    }

    /**
     * Get only pokemon name from API.
     *
     * @param ProductInterface $product
     * @return string|null
     */
    private function getPokemonNameFromApi(ProductInterface $product): ?string
    {
        try {
            return $this->getPokemonDetails($product)['name'] ?? null;
        } catch (Exception $exception) {
            $this->logHandler->logError($exception);
            $this->messageManager->addErrorMessage(
                __('An error occurred while retrieving the pokemon name. Please try again later or contact us.')
            );
            return null;
        }
    }
}
