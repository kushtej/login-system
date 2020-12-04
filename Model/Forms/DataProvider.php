<?php

namespace Codilar\CouponModule\Model\Forms;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Codilar\CouponModule\Model\ResourceModel\DetailsFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;

    private $request;

    /**
     * @var Collection
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;
    /**
     * @var DetailsFactory
     */
    private $detailsFactory;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param DetailsFactory $detailsFactory
     * @param DetailsRepositoryInterface $detailsRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        DetailsFactory $detailsFactory,
        DetailsRepositoryInterface $detailsRepository,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        $this->detailsFactory = $detailsFactory;
        $this->detailsRepository = $detailsRepository;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $id = $this->request->getParam('id');
        $items = $this->collectionFactory->create()->addFieldToFilter('id', $id)->getItems();
        foreach ($items as $item) {
            $coupondata = $item->getData();
            $coupon_end_date = $coupondata['end_date'];
            $this->loadedData[$item->getId()] = $coupondata;
        }
        return $this->loadedData;
    }
}
