<?php

namespace Codilar\CouponModule\Api\Data;

use Codilar\CouponModule\Model\Details;

/**
 * Interface IssueInterface
 * @package Codilar\CouponModule\Api\Data
 */
interface DetailsInterface
{
    /**
     * @param Details $issue
     * @return mixed
     */
    public function init(Details $issue);

    /**
     * @return int
     */
    public function getCouponName();

    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @return string
     */
    public function getRule();

    /**
     * @return int
     */
    public function getCouponStatus();

        /**
     * @return int
     */
    public function getCouponOperation();


    /**
     * @param string
     * @return bool
     */
    public function getAllCoupons($couponCode);
}
