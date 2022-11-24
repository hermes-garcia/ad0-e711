<?php
declare(strict_types=1);

namespace Hermes\Test\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Tax\Model\ResourceModel\TaxClass\CollectionFactory;

class LoadProductTax implements ObserverInterface
{

    /** @var CollectionFactory  */
    protected CollectionFactory $taxCollectionFactory;

    public function __construct(CollectionFactory $taxCollectionFactory)
    {
        $this->taxCollectionFactory = $taxCollectionFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Zend_Log_Exception
     */
    public function execute(Observer $observer)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/hermes.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info("Observer triggered!");
        /** @var Product $product */
        $product = $observer->getData("product");
        $logger->info("prod id: " . $product->getId());
        $taxCollection = $this->taxCollectionFactory->create();
        $taxClass = $taxCollection->addFieldToFilter('class_id',$product->getTaxClassId())->getFirstItem();
        $logger->info("tax class name: " . $taxClass->getData('class_name'));
    }
}
