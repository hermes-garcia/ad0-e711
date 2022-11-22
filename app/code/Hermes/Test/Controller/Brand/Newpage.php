<?php
declare(strict_types=1);

namespace Hermes\Test\Controller\Brand;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Newpage implements HttpGetActionInterface
{

    protected PageFactory $pageFactory;
    protected JsonFactory $jsonFactory;
    protected Context $context;
    protected StoreManagerInterface $storeManager;

    public function __construct(
        PageFactory $pageFactory,
        JsonFactory $jsonFactory,
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->pageFactory = $pageFactory;
        $this->context = $context;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/hermes.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info("store manager");
        $logger->info("base url: " . $this->storeManager->getStore()->getBaseUrl());
        $stores = $this->storeManager->getStores();
        foreach ($stores as $store) {
            $logger->info("store base url: " . $store->getCode());
            if ($store->getId() === $this->storeManager->getStore()->getId()) {
                $logger->info("current store name: " . $store->getName());
            }
        }
        return $this->pageFactory->create();
    }
}
