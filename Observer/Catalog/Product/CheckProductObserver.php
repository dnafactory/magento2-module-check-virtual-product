<?php

namespace DNAFactory\CheckVirtualProduct\Observer\Catalog\Product;

use Magento\Backend\App\Action;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class CheckProductObserver implements ObserverInterface
{
    const PRODUCT_VIRTUAL_TYPES = [
        'virtual',
        'downloadable'
    ];

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * CheckProductObserver constructor.
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        /** @var ProductInterface $product */
        $product = $observer->getData('product');

        if ($product instanceof ProductInterface && $product->getId() && $product->getTypeId()) {
            if (in_array($product->getTypeId(), self::PRODUCT_VIRTUAL_TYPES)) {
                $this->messageManager->addErrorMessage(__('ATTENZIONE!!!! Avete creato un prodotto Virtuale / Scaricabile... forse avete dimenticato di inserire il peso?'));
            }
        }
    }
}
