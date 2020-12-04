<?php

namespace Codilar\CouponModule\Model\ResourceModel\Details;

use Codilar\CouponModule\Model\Details as DetailModel;
use Codilar\CouponModule\Model\ResourceModel\Details as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DetailModel::class, ResourceModel::class);
    }
}
