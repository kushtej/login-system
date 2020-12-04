<?php

namespace Codilar\CouponModule\Ui\Component\Form\Element;

class Input extends \Magento\Ui\Component\Form\Element\Input
{
    /**
     * Prepare component configuration
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();

        $config = $this->getData('config');
        if (isset($config['dataScope']) && $config['dataScope'] == 'start_date') {
            $config['default'] = date('m-d-Y');
            $this->setData('config', (array)$config);
        }
    }
}
