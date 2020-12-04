<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Block;

use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory as VendorFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template as parentAlias;

/**
 * Class VendorData
 * @package Codilar\CouponModule\Block
 */
class VendorData extends parentAlias
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * VendorData constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param parentAlias\Context $context
     * @param CollectionFactory $collectionFactory
     * @param VendorFactory $vendorFactory
     * @param array $data
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        parentAlias\Context $context,
        CollectionFactory $collectionFactory,
        VendorFactory $vendorFactory,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->vendorFactory = $vendorFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $request = $this->getRequest()->getParams();
        $vendorId = $request['id'];
        $productCollection = $this->collectionFactory->create();
        $collection = $productCollection->addAttributeToSelect('*')->addAttributeToFilter('coupon_name', $vendorId);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }

    /**
     * @return array
     */
    public function getCouponModule()
    {
        $vendorId = $this->getRequest()->getParams();
        $collection = $this->vendorFactory->create()->addFieldToFilter('id', $vendorId)->getData();
        foreach ($collection as $item) {
            $data['coupon_name'] = $item['coupon_name'];
            $data['coupon_rule'] = $item['coupon_rule'];
            $data['end_date'] = $item['end_date'];
            $data['date'] = $item['start_date'];
        }
        return $data;
    }

}
