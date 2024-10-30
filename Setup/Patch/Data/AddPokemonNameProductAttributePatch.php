<?php
/**
 * File: AddPokemonNameProductAttributePatch.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);
/*
 * File: AddPokemonNameProductAttributePatch.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 */

namespace Juszczyk\PokemonProduct\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Validator\ValidateException;

class AddPokemonNameProductAttributePatch implements DataPatchInterface, PatchRevertableInterface
{
    private const string POKEMON_NAME_ATTRIBUTE_CODE = 'pokemon_name';
    private const array POKEMON_NAME_ATTRIBUTE_DATA = [
        'is_visible_in_grid' => false,
        'is_html_allowed_on_front' => false,
        'visible_on_front' => true,
        'visible' => true,
        'global' => ScopedAttributeInterface::SCOPE_STORE,
        'label' => 'Pokemon Name',
        'source' => null,
        'type' => 'varchar',
        'is_used_in_grid' => false,
        'required' => false,
        'input' => 'text',
        'is_filterable_in_grid' => false,
        'sort_order' => 900,
        'group' => 'Product Details',
        'used_in_product_listing' => true
    ];

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory
    ) {
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - then under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        if ($this->attributeExists($eavSetup)) {
            $this->updateAttribute($eavSetup);
            return $this;
        }
        $this->createAttribute($eavSetup);

        return $this;
    }

    /**
     * Rollback all changes, done by this patch
     *
     * @return void
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $this->removeAttribute($eavSetup);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Check if pokemon_name attribute exists.
     *
     * @param EavSetup $eavSetup
     * @return bool
     */
    private function attributeExists(EavSetup $eavSetup): bool
    {
        return (bool) $eavSetup->getAttribute(Product::ENTITY, self::POKEMON_NAME_ATTRIBUTE_CODE);
    }

    /**
     * Update pokemon_name attribute.
     *
     * @param EavSetup $eavSetup
     * @return void
     */
    private function updateAttribute(EavSetup $eavSetup): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup->updateAttribute(
            Product::ENTITY,
            self::POKEMON_NAME_ATTRIBUTE_CODE,
            self::POKEMON_NAME_ATTRIBUTE_DATA
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Create pokemon_name attribute.
     *
     * @param EavSetup $eavSetup
     * @return void
     * @throws LocalizedException
     * @throws ValidateException
     */
    private function createAttribute(EavSetup $eavSetup): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::POKEMON_NAME_ATTRIBUTE_CODE,
            self::POKEMON_NAME_ATTRIBUTE_DATA
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Remove pokemon_name attribute.
     *
     * @param EavSetup $eavSetup
     * @return void
     */
    private function removeAttribute(EavSetup $eavSetup): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::POKEMON_NAME_ATTRIBUTE_CODE
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
