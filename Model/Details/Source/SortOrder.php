<?php

namespace Codilar\CouponModule\Model\Details\Source;

use Magento\Framework\Data\OptionSourceInterface;

class SortOrder implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'asc', 'label' => __('Ascending')],
            ['value' => 'desc', 'label' => __('Descending')]
        ];
    }
}
