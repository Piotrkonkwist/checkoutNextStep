<?php
namespace Monogo\ModuleNewStepCheckout\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Index extends \Magento\Framework\View\Element\Template
{
    private $categoryFactory;
    private $productCollection;
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }

    public function productList()
    {
        $productCollection2 = $this->getProductCollectionByCategories("41");
        foreach ($productCollection2 as $product) {
            echo $product->getId() . '<br />';
            echo $product->getName() . '<br />';
            echo $product->getPrice() . '<br />';
        }
        return __('Hello BB World');
    }

    public function testList()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        // filter current website products
        $collection->addWebsiteFilter();

        $collection->addAttributeToSort('entity_id', 'desc');
        $catalog_ids = [41];
        $collection->addCategoriesFilter(['in' => $catalog_ids]);

        // filter current store products
        $collection->addStoreFilter();

//        $collection->getFilter("ID:41")

        // set visibility filter
        $collection->setVisibility($objectManager->get('\Magento\Catalog\Model\Product\Visibility')->getVisibleInSiteIds());

        // fetching only 5 products
        $collection->setPageSize(5);
        foreach ($collection as $product) {
            echo $product->getId() . '<br />';
            echo $product->getName() . '<br />';
        }
    }

    public function getProductCollectionByCategories($id)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')->addCategoriesFilter(['in' => $id]);
        return $collection;
    }
}
