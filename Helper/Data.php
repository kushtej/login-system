<?php

namespace Codilar\CouponModule\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Codilar\CouponModule\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_HELLOWORLD = 'coupon/';

    /**
     * @param $field
     * @param null $storeId
     * @return String
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $code
     * @param null $storeId
     * @return String
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_HELLOWORLD . 'details/' . $code, $storeId);
    }


}
