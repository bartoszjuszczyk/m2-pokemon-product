<?php
/**
 * File: ConfigProvider.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model;

use Juszczyk\PokemonProduct\Api\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class ConfigProvider implements ConfigProviderInterface
{
    private const string XML_PATH_JUSZCZYK_POKEMON_PRODUCT_GENERAL_ENABLED = 'juszczyk_pokemon_product/general/enabled';

    private const string XML_PATH_JUSZCZYK_POKEMON_PRODUCT_GENERAL_API_URL = 'juszczyk_pokemon_product/general/api_url';

    /**
     * ConfigProvider class constructor.
     *
     * @param ScopeConfigInterface  $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig,
        protected readonly StoreManagerInterface $storeManager
    ) {
    }

    /**
     * @inerhitDoc
     */
    public function isModuleEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_JUSZCZYK_POKEMON_PRODUCT_GENERAL_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inerhitDoc
     */
    public function getApiUrl(?int $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_JUSZCZYK_POKEMON_PRODUCT_GENERAL_API_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
