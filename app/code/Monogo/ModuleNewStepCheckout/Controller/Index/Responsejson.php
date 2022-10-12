<?php

namespace Monogo\ModuleNewStepCheckout\Controller\Index;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Asset\Repository;

class Responsejson extends Action
{
    /**
     * The JsonResultFactory to render with.
     *
     * @var jsonResultFactory
     */
    protected $jsonResultFactory;
    private $categoryFactory;
    protected $_productCollectionFactory;

    /**
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     * @param JsonFactory $jsonResultFactory
     * @param CollectionFactory $productCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        JsonFactory $jsonResultFactory,
        CollectionFactory $productCollectionFactory,
        Repository $assetRepo,
        array $data = []
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->categoryFactory = $categoryFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->assetRepo = $assetRepo;
        parent::__construct($context);
    }

    public function getProductCollectionByCategories($id)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')->addCategoriesFilter(['in' => $id]);
        return $collection;
    }

    /**
     * @obj $product
     * @return Image path
     */
    public function getImagePathCache($product)
    {
        $objectmanager = \Magento\Framework\App\ObjectManager::getInstance();
        $helpertImport = $objectmanager->get('\Magento\Catalog\Helper\Image');

        $imageUrl = $helpertImport->init($product, 'category_page_grid')
            ->setImageFile($product->getSmallImage())
            ->getUrl();
        return $imageUrl;
    }

    /**
     * Show the Controller Response Types JSON Result.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $productCollection = $this->getProductCollectionByCategories("41");
        $data = [];
        foreach ($productCollection as $key => $product) {
            $data[]  = ['id' => $product->getId(),
                            'name' => $product->getName(),
                            'sku' => $product->getSku(),
                            'price' => $product->getPrice(),
                            'productUrl' => $product->getProductUrl(),
                            'imgUrl' => $this->getImagePathCache($product)
                ];
        }
        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        return $result;
    }
}
