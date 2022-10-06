<?php
namespace Monogo\ModuleNewStepCheckout\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }

    public function productList()
    {
        return __('Hello World');
    }
}
