<?php
/**
 * File: AddPokemonNameToProduct.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Plugin;

use Juszczyk\PokemonProduct\ViewModel\Pokemon;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Product\View;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page as ResultPage;

class AddPokemonNameToProduct
{
    /**
     * AddPokemonNameToProduct class constructor.
     *
     * @param Pokemon                    $pokemonViewModel
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        protected readonly Pokemon $pokemonViewModel,
        protected readonly ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Set product view page title as product name combined with pokemon name.
     *
     * @param View $subject
     * @param View $result
     * @param ResultPage $resultPage
     * @param  $productId
     * @return View
     */
    public function afterPrepareAndRender(
        View $subject,
        View $result,
        ResultPage $resultPage,
        $productId
    ): View {
        $layout = $resultPage->getLayout();
        $pageMainTitle = $layout->getBlock('page.main.title');
        if (! $pageMainTitle) {
            return $result;
        }
        if ($productName = $this->getProductName((int)$productId)) {
            $pageMainTitle->setPageTitle($productName);
        }
        return $result;
    }

    /**
     * Get product name combined with pokemon name.
     *
     * @param int $productId
     * @return string|null
     */
    protected function getProductName(int $productId): ?string
    {
        $product = $this->getProduct($productId);
        return $this->pokemonViewModel->getProductName($product);
    }

    /**
     * Get product by product ID.
     *
     * @param  int $productId
     * @return ProductInterface|null
     */
    protected function getProduct(int $productId): ?ProductInterface
    {
        try {
            return $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
