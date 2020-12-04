<?php

namespace Codilar\CouponModule\Model;

use Codilar\CouponModule\Model\ResourceModel\Details as ResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Details
 * @package Codilar\CouponModule\Model
 */
class Details extends AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return String
     */
    public function getCouponName()
    {
        return $this->getData('coupon_name');
    }

    /**
     * @param $name
     * @return Details
     */
    public function setCouponName($name)
    {
        return $this->setData('coupon_name', $name);
    }

    /**
     * @return String
     */
    public function getStartDate()
    {
        return $this->getData('start_date');
    }

    /**
     * @param $number
     * @return Details
     */
    public function setStartDate($date)
    {
        return $this->setData('start_date', $date);
    }

    /**
     * @return String
     */
    public function getRule()
    {
        return $this->getData('coupon_rule');
    }

    /**
     * @param $email
     * @return Details
     */
    public function setRule($coupon_rule)
    {
        return $this->setData('coupon_rule', $coupon_rule);
    }

    /**
     * @return String
     */
    public function getEndDate()
    {
        return $this->getData('end_date');
    }

    /**
     * @param $end_date
     * @return Details
     */
    public function setEndDate($end_date)
    {
        return $this->setData('end_date', $end_date);
    }

    /**
     * @return int
     */
    public function getCouponStatus()
    {
        return $this->getData('coupon_status');
    }

    /**
     * @param $status
     * @return Details
     */
    public function setCouponStatus($status)
    {
        return$this->setData('coupon_status', $status);
    }


}
