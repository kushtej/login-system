<?php

namespace Codilar\CouponModule\Model\ResourceModel;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Model\Details as Model;
use Codilar\CouponModule\Model\DetailsFactory as ModelFactory;
use Codilar\CouponModule\Model\ResourceModel\Details as ResourceModel;
use Codilar\CouponModule\Model\ResourceModel\Details\Collection;
use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class DetailsRepository
 * @package Codilar\CouponModule\Model\ResourceModel
 */
class DetailsRepository implements DetailsRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * IssueRepository constructor.
     * @param ModelFactory $modelFactory
     * @param CollectionFactory $collectionFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        ModelFactory $modelFactory,
        CollectionFactory $collectionFactory,
        ResourceModel $resourceModel
    ) {
        $this->resourceModel=$resourceModel;
        $this->modelFactory=$modelFactory;
        $this->collectionFactory=$collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function load($value, $field = null)
    {
        $model = $this->create();
        $this->resourceModel->load($model, $value, $field);
        if (!$model->getId()) {
            throw NoSuchEntityException::singleField($field, $value);
        }
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return $this->modelFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function save(Model $model)
    {
        $this->resourceModel->save($model);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(Model $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (\Exception $exception) {
            throw new LocalizedException(__("Error deleting Model with Id : " . $model->getId()));
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    public function getAllCoupons($couponCode)
    {
        $collections = $this->getCollection()->getData();
        foreach ($collections as $collection){
            $id = $collection->getId();
            if($couponCode == $collection->getCouponName($id)){
                return 1;
            }
        }
        return 0;
    }

}
