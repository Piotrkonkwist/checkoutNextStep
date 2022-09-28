<?php
namespace Monogo\ModuleNewStepCheckout\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\TestFramework\ObjectManager;

class Resultjson extends \Magento\Framework\App\Action\Action
{
    /**
     * The PageFactory to render with.
     *
     * @var PageFactory
     */
    protected $_resultsPageFactory;

    /**
     * Set the Context and Result Page Factory from DI.
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->_resultsPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Show the Controller Response Types JSON Result.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        return $this->_resultsPageFactory->create();
    }
}
