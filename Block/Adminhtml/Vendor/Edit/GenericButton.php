<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Block\Adminhtml\Vendor\Edit;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

abstract class GenericButton implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param DetailsRepositoryInterface $detailsRepository
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        DetailsRepositoryInterface $detailsRepository,
        ManagerInterface $messageManager
    ) {
        $this->context = $context;
        $this->detailsRepository = $detailsRepository;
        $this->messageManager = $messageManager;
    }

    /**
     * @return ManagerInterface|array
     */
    public function getId()
    {
        try {
            $id = $this->context->getRequest()->getParam('id');
            return $this->detailsRepository->load($id)->getId();
        } catch (NoSuchEntityException $e) {
            return $this->messageManager->addErrorMessage($e->getMessage());
        }
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}