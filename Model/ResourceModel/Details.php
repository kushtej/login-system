<?php

namespace Codilar\CouponModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Details
 * @package Codilar\CouponModule\Model\ResourceModel
 */
class Details extends AbstractDb
{
    /**
     * Database Table Name
     */
    const TABLE_NAME = "codilar_coupon_details";

    /**
     * Primary Key
     */
    const ID_FIELD = "id";
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD);
    }
}
