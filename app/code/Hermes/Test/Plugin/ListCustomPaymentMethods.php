<?php
declare(strict_types=1);

namespace Hermes\Test\Plugin;

use Magento\Payment\Model\MethodList;
use Magento\Quote\Api\Data\CartInterface;

class ListCustomPaymentMethods
{

    /**
     * @param MethodList $subject
     * @param array $result
     * @param CartInterface $quote
     * @return array
     * @throws \Zend_Log_Exception
     */
    public function afterGetAvailableMethods (
        MethodList $subject,
        array $result,
        CartInterface  $quote
    ): array
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/hermes.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info("Plugin triggered!");
        /** @var \Magento\Payment\Model\MethodInterface $method */
        foreach ($result as $method) {
            $logger->info("available methods: " .$method->getCode() );
        }

        return $result;
    }

}
