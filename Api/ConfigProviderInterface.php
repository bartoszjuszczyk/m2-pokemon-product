<?php

/**
 * File: ConfigProviderInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api;

interface ConfigProviderInterface
{
    /**
     * Check if module is enabled.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isModuleEnabled(?int $storeId = null): bool;

    /**
     * Get PokeAPI base URL.
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getApiUrl(?int $storeId = null): ?string;
}
