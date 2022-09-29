<?php
namespace Monogo\ModuleNewStepCheckout\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\TestFramework\ObjectManager;
use Magento\Catalog\Model\ProductCategoryList;

class CheckoutCategory extends \Magento\Framework\App\Action\Action
{
    /**
     * The PageFactory to render with.
     *
     * @var PageFactory
     */

    /**
     * @var ProductCategoryList
     */
    public $productCategory;

    protected $_resultsPageFactory;

    /**
     * Set the Context and Result Page Factory from DI.
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductCategoryList $productCategory
    ) {
        $this->_resultsPageFactory = $resultPageFactory;
        $this->productCategory = $productCategory;
        parent::__construct($context);
    }

    public function getCategoryIds(int $productId)
    {
        $categoryIds = $this->productCategory->getCategoryIds($productId);
        $category = [];
        if ($categoryIds) {
            $category = array_unique($categoryIds);
        }
        return $category;
    }

    /**
     * Show the Controller Response Types JSON Result.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        $test = $this->getCategoryIds(41);
        var_dump($test);
        return $this->_resultsPageFactory->create();
    }
}
