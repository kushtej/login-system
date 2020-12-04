<?php

namespace Codilar\CouponModule\Controller\Details;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;

    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     * @param DetailsRepositoryInterface $detailsRepository
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        DetailsRepositoryInterface $detailsRepository,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->detailsRepository = $detailsRepository;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|\Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $vendorData = $this->detailsRepository->getCollection()->addFieldToFilter('coupon_rule', $identifier)->getData();
        foreach ($vendorData as $items) {
            if (strpos($identifier, $items['coupon_rule']) !== false) {
                var_dump("hello");die;
                $request->setModuleName('CouponModule');
                $request->setControllerName('index');
                $request->setActionName('index');
                $request->setParams([
                'id' => $items['id']
            ]);
                return $this->actionFactory->create(Forward::class, ['request' => $request]);
            }
        }
    }
}
