<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Controller\Adminhtml\Details;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;

class InlineEdit extends Action implements HttpPostActionInterface
{
    /**
     * @var DetailsRepositoryInterface
     */
    private $vendorDataRepository;
    /**
     * @var Action\Context
     */
    private $context;
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * InlineEdit constructor.
     * @param DetailsRepositoryInterface $vendorDataRepository
     * @param JsonFactory $resultJsonFactory
     * @param Action\Context $context
     */
    public function __construct(
        DetailsRepositoryInterface $vendorDataRepository,
        JsonFactory $resultJsonFactory,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->vendorDataRepository = $vendorDataRepository;
        $this->context = $context;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        try {
            foreach ($postItems as $vendor) {
                $model = $this->vendorDataRepository->load($vendor['id']);
                $model->addData($vendor);
                $this->vendorDataRepository->save($model);
            }
            $data = [
                'error' => false,
                'messages' => [__("Vendor saved successfully")]
            ];
        } catch (LocalizedException $localizedException) {
            $data = [
                'error' => true,
                'messages' => [$localizedException->getMessage()]
            ];
        } catch (Exception $exception) {
            $data = [
                'error' => true,
                'messages' => [__($exception->getMessage())]
            ];
        }

        return $resultJson->setData($data);
    }
}
