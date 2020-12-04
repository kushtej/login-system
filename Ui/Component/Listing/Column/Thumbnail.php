<?php

namespace Codilar\CouponModule\Ui\Component\Listing\Column;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;
    /**
     * @var array
     */
    private $data;

    /**
     * Thumbnail constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param Image $end_dateHelper
     * @param UrlInterface $urlBuilder
     * @param ObjectManagerInterface $objectManager
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        UrlInterface $urlBuilder,
        ObjectManagerInterface $objectManager,
        array $data = []
    ) {

        $this->context = $context;
        $this->uiComponentFactory = $uiComponentFactory;
        $this->components = $components;
        $this->urlBuilder = $urlBuilder;
        $this->objectManager = $objectManager;
        $this->data = $data;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {

        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_src'] = $item['end_date'];
                $item[$fieldName . '_alt'] = $item['end_date'];
                $item[$fieldName . '_orig_src'] = $item['end_date'];
            }
        }
        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
