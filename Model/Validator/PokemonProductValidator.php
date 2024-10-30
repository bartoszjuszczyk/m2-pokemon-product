<?php

/**
 * File: PokemonProductValidator.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Validator;

use Juszczyk\PokemonProduct\Api\ConfigProviderInterface;
use Juszczyk\PokemonProduct\Api\Validator\PokemonProductValidatorInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class PokemonProductValidator implements PokemonProductValidatorInterface
{
    /**
     * PokemonProductValidator class constructor.
     *
     * @param ConfigProviderInterface $configProvider
     */
    public function __construct(protected readonly ConfigProviderInterface $configProvider)
    {
    }

    /**
     * @inheritDoc
     */
    public function shouldUsePokemonDetails(ProductInterface $product): bool
    {
        return $this->configProvider->isModuleEnabled() && $product->hasPokemonName();
    }
}
