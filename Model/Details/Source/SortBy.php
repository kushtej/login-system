<?php

namespace Codilar\CouponModule\Model\Details\Source;

use Magento\Framework\Data\OptionSourceInterface;

class SortBy implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'coupon_name', 'label' => __('Vendor Name')],
            ['value' => 'start_date', 'label' => __('Newest')],
            ['value' => 'highest', 'label' => __('Maximum No Of Product')]

        ];
    }
}
