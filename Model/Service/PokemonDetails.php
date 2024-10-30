<?php
/**
 * File: PokemonDetails.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Service;

use Juszczyk\PokemonProduct\Api\Service\PokemonDetailsInterface;
use Juszczyk\PokemonProduct\Model\Api\Client\PokemonApi;
use Juszczyk\PokemonProduct\Model\Api\LogHandler;
use Juszczyk\PokemonProduct\Model\Validator\PokemonProductValidator;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Message\ManagerInterface;

class PokemonDetails implements PokemonDetailsInterface
{
    /**
     * @var array
     */
    protected array $pokemonDetails = [];

    /**
     * Pokemon class constructor.
     *
     * @param PokemonApi $pokemonApi
     * @param PokemonProductValidator $pokemonProductValidator
     * @param LogHandler $logHandler
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        protected readonly PokemonApi $pokemonApi,
        protected readonly PokemonProductValidator $pokemonProductValidator,
        protected readonly LogHandler $logHandler,
        protected readonly ManagerInterface $messageManager
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPokemonDetails(ProductInterface $product): array
    {
        $pokemonName = $product->getPokemonName();
        if (!isset($this->pokemonDetails[$pokemonName])) {
            $this->pokemonDetails[$pokemonName] = $this->pokemonApi->getPokemonDetails($product);
        }
        return $this->pokemonDetails[$pokemonName] ?? [];
    }
}
