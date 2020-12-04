<?php

namespace Codilar\CouponModule\Api;

use Codilar\CouponModule\Model\Details as Model;
use Codilar\CouponModule\Model\ResourceModel\Details\Collection;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface IssueRepositoryInterface
 * @package Codilar\CouponModule\Api
 */
interface DetailsRepositoryInterface
{
    /**
     * @param string $value
     * @param string $field
     * @return Model
     * @throws NoSuchEntityException
     */
    public function load($value, $field = null);

    /**
     * @return Model
     */
    public function create();

    /**
     * @param Model $model
     * @return Model
     * @throws AlreadyExistsException
     */
    public function save(Model $model);

    /**
     * @param Model $model
     * @return $this
     * @throws LocalizedException
     */
    public function delete(Model $model);

    /**
     * @return Collection
     */
    public function getCollection();


}
