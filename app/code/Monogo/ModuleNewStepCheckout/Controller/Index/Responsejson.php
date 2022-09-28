<?php

namespace Monogo\ModuleNewStepCheckout\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;

class Responsejson extends Action
{
    /**
     * The JsonResultFactory to render with.
     *
     * @var jsonResultFactory
     */
    protected $jsonResultFactory;

    /**
     * Set the Context and Result Page Factory from DI.
     * @param Context     $context
     * @param JsonResultFactory $jsonResultFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        array $data = []
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
    }

    /**
     * Show the Controller Response Types JSON Result.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */

    public function execute()
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');

// get quote items collection
        $itemsCollection = $cart->getQuote()->getItemsCollection();

// get array of all items what can be display directly
        $itemsVisible = $cart->getQuote()->getAllVisibleItems();

// get quote items array
        $items = $cart->getQuote()->getAllItems();

        $data = [];
        foreach($items as $key => $item) {
            $data[$key]['ID'] = $item->getProductId();
            $data[$key]['Name'] = $item->getName();
            $data[$key]['Sku'] = $item->getSku();
            $data[$key]['Quantity'] = $item->getQty();
            $data[$key]['Price'] = $item->getPrice();
            }

        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        return $result;
    }

}
