<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Controller\Adminhtml\Details;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Helper\Data;
use Codilar\CouponModule\Model\Details;
use Codilar\CouponModule\Model\ResourceModel\DetailsFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Setup\Exception;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\OfflineShipping\Model\Source\SalesRule;


class Save extends Action
{
    /**
     * @var Details
     */
    private $details;
    /**
     * @var DetailsFactory
     */
    private $detailsFactory;
    /**
     * @var Action\Context
     */
    private $context;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;
    /**
     * @var UrlRewriteFactory
     */
    private $urlRewriteFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Data
     */
    private $helperData;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param Details $details
     * @param DetailsFactory $detailsFactory
     * @param DetailsRepositoryInterface $detailsRepository
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Data $helperData
     */
    public function __construct(
        Action\Context $context,
        Details $details,
        DetailsFactory $detailsFactory,
        DetailsRepositoryInterface $detailsRepository,
        UrlRewriteFactory $urlRewriteFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Data $helperData
    ) {
        parent::__construct($context);
        $this->details = $details;
        $this->detailsFactory = $detailsFactory;
        $this->context = $context;
        $this->detailsRepository = $detailsRepository;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->storeManager = $storeManager;
        $this->helperData = $helperData;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $formData = $this->getRequest()->getParams();
        $data = [
            'coupon_name' => $formData['coupon_name'],
            'coupon_rule' => $formData['coupon_rule'],
            'end_date' => $formData['vendor_end_date'],
            'start_date' => $formData['start_date'],
            'coupon_status' => $formData['coupon_status']
        ];

        // if (isset($formData['vendor_end_date'])) {
        //     $data['end_date'] = $formData['vendor_end_date'][0]['url'];
        // } else {
        //     $data['end_date'] = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'codilar/banner/' . $this->helperData->getGeneralConfig('placeholder');
        // }
        if ($formData['id'] === "") {
            $model = $this->detailsRepository->create();
            $model->setData($data);
            try {
                $this->detailsRepository->save($model);
                $this->messageManager->addSuccessMessage('Successfully Inserted Coupon Details.');
            } catch (Exception $exception) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the details.'));
                return $this->resultRedirectFactory->create()->setPath('coupon/details/edit');
            } catch (AlreadyExistsException $exception) {
                $this->messageManager->addErrorMessage(__('Duplicate coupon'));
                return $this->resultRedirectFactory->create()->setPath('coupon/details/edit/id/' . $formData['id']);
            }
        } else {
            try {
                $model = $this->detailsRepository->load($formData['id']);
                $model->setCouponName($data['coupon_name']);
                $model->setVendorDate($data['start_date']);
                $model->setLink($data['coupon_rule']);
                $model->setImage($data['end_date']);
                $model->setAccountStatus($data['coupon_status']);
                $this->detailsRepository->save($model);
            } catch (AlreadyExistsException $exception) {
                $this->messageManager->addErrorMessage(__('Duplicate coupon'));
                $result = $this->resultRedirectFactory->create();
                return $result->setPath('coupon/details/edit/id/' . $formData['id']);
            } catch (Exception $exception) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the details.'));
                return $this->resultRedirectFactory->create()->setPath('coupon/details/edit');
            }
        }

//         $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//         $orders = $objectManager->create('Magento\Sales\Model\Order');
//         var_dump(($orders));


//$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
//$storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
//$storeID       = $storeManager->getStore()->getStoreId();
//$storeName     = $storeManager->getStore()->getName();
////$storeEmail    = $storeManager->getStore()->getEmail();
//echo $storeID;
//echo $storeName;
//
//$customerSession = $om->get('Magento\Customer\Model\Session');
//if($customerSession->isLoggedIn()) {
//    echo $customerSession->getCustomer()->getEmail(); // get Email
//}


//         $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
// $storeManager  = $objectManager->get('Magento\Customer\Model\Customer');
// echo $storeManager->getStore();
//$storeID       = $storeManager->getStore()->getStoreId();
//$storeName     = $storeManager->getStore()->getName();
////$storeEmail    = $storeManager->getStore()->getEmail();
//echo $storeID;
//echo $storeName;
//
//$customerSession = $om->get('Magento\Customer\Model\Session');
//if($customerSession->isLoggedIn()) {
//    echo $customerSession->getCustomer()->getEmail(); // get Email
//}






// //        echo $custLastName= $orders->getCustomerLastname();
//         die;
        return $this->resultRedirectFactory->create()->setPath('coupon/details/index');
    }
}
