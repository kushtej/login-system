<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Block\Widget;

use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Codilar\CouponModule\Model\ResourceModel\Details\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Vendors extends Template implements BlockInterface
{
    protected $_template = "widget/posts.phtml";
    /**
     * @var CollectionFactory
     */
    private $collection;

    /**
     * Vendors constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function getCouponModule()
    {
        /**
         * @var Collection $collection
         */
        $field = $this->getData('collection_sort_by');
        $direction = $this->getData('collection_sort_order');
        $noOfProduct = $this->getData('posts');
        $collection = $this->collection->create();
        return $collection->setOrder($field, $direction)->setPageSize($noOfProduct);
    }
}
