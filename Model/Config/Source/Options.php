<?php

namespace Codilar\CouponModule\Model\Config\Source;

use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Action\Context;

/**
 * Class Options
 * @package Codilar\CouponModule\Model\Config\Source
 */
class Options extends AbstractSource
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var Context
     */
    protected $context;

    /**
     * Options constructor
     * @param CollectionFactory $collection
     */
    public function __construct(
        CollectionFactory $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        /**
         * @var $data \Codilar\CouponModule\Model\ResourceModel\Details\Collection
         */
        $data = $this->collection->create();
        $this->_options = [['label' => ' ', 'value' => ' ']];
        foreach ($data as $item) {
            if ($item['coupon_status'] == 1) {
                array_push(
                    $this->_options,
                    ['label' => $item['coupon_name'], 'value' => $item['id']]
                );
            }
        }

        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
