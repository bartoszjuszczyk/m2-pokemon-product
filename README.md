# Juszczyk_PokemonProduct module

The Juszczyk_PokemonProduct module enables you to dynamically add Pokemon name and image to product on
listing and view page based on attribute assigned to product.

## Installation details

The Juszczyk_PokemonProduct module makes reversible changes in database during installation. You can disable or
uninstall this module and changes will be reverted.

We recommend install this module with Composer:

```
composer require juszczyk/pokemon-product
bin/magento module:enable Juszczyk_PokemonProduct
bin/magento setup:upgrade
bin/magento setup:static-content:deploy (if applicable)
```

For information about a module installation in Magento 2,
see [Enable or disable modules](https://experienceleague.adobe.com/docs/commerce-operations/installation-guide/tutorials/manage-modules.html).

## Configuration

The Juszczyk_PokemonProducts provides configuration possibility at backend panel. After module install there will be the
tab named "Juszczyk" and the section named "Pokemon Product".

In group "General" you can choose if module should be enabled and/or change PokeAPI base URL.

Default values for this configuration is:

- Module is disabled
- PokeAPI base URL is: `https://pokeapi.co/api/v2`

## Additional information

The Juszczyk_PokemonProduct module integrate Magneto with PokeAPI.
