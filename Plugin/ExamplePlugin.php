<?php


namespace Codilar\CouponModule\Plugin;

use Codilar\CouponModule\Api\Data\DetailsInterface;
use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Model\Total\Quote\Custom;
use \Magento\Framework\Exception\LocalizedException as LocalizedException;
use \Magento\Quote\Api\CouponManagementInterface;
use \Magento\Framework\Exception\CouldNotDeleteException;
use \Magento\Framework\Exception\CouldNotSaveException;
use \Magento\Framework\Exception\NoSuchEntityException;


/*
 * @class ExamplePlugin
 *
 * Plugin for Managing Coupon Post(when coupon form is submitted this form will be called)
 */
class ExamplePlugin
{
    /*
     * @param \Magento\Checkout\Controller\Cart\CouponPost $subject
     * @param \Callable\Proceed
     * @return \Magento\Framework\Controller\Result\Redirect
     *
     * Plugin which executes around the execute() of the \Magento\Checkout\Controller\Cart\CouponPost
     * via $subject can use the public methods of coupon post and through $proceed you can execute the actual execute()
     */

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private $cart;
    /**
     * @var DetailsInterface
     */
    private $detailsRepository;
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;
    /**
     * @var \Codilar\CouponModule\Model\Total\Quote\Custom
     */
    private $customDetails;

    /**
     * ExamplePlugin constructor.
     * @param \Magento\Checkout\Model\Cart $cart
     * @param DetailsRepositoryInterface $detailsRepository
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Codilar\CouponModule\Model\Total\Quote\Custom $customDetails
     */
    public function __construct(\Magento\Checkout\Model\Cart $cart,
                                DetailsRepositoryInterface $detailsRepository,
                                \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
                                \Codilar\CouponModule\Model\Total\Quote\Custom $customDetails)
    {
        $this->cart = $cart;
        $this->details = $detailsRepository;
        $this->quoteRepository = $quoteRepository;
        $this->customDetails = $customDetails;
    }

    public function aroundExecute(\Magento\Checkout\Controller\Cart\CouponPost $subject, callable $proceed)
	{

//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
//        $logger = new \Zend\Log\Logger();
        #the code to be executed before going into the actual execute method
        $result = $proceed();#can replace with the actual code of coupon post execute()
        #after the actual execute method is executed write whatever proper condition to be executed
//        $logger->addWriter($writer);


        $couponCode = $subject->getRequest()->getParam('remove') == 1
            ? ''
            : trim($subject->getRequest()->getParam('coupon_code'));

        $this->customDetails->getCouponCode($couponCode);
        //$this->detailsRepository->getAllCoupons($couponCode);
//        $cartQuote = $this->cart->getQuote();
//        $cartQuote=$cartQuote+500;
//
//        $this->detailsRepository->getAllCoupons($couponCode);
//
//        $cartQuote->getShippingAddress()->setCollectShippingRates(true);
//        $this->quoteRepository->save($cartQuote);


        //var_dump($couponCode);
//        try{
//            $itemsCount = $cartQuote->getItemsCount();
//            if ($itemsCount) {
//                $cartQuote->getShippingAddress()->setCollectShippingRates(true);
//                $cartQuote->setCouponCode($couponCode)->collectTotals();
//                $subject->quoteRepository->save($cartQuote);
//            }
//
//
//
//
//        }catch (LocalizedException $e) {
//            //$this->messageManager->addErrorMessage($e->getMessage());
//            throw new CouldNotSaveException(__('The coupon code couldn\'t be applied: ' .$e->getMessage()), $e);
//
//        } catch (\Exception $e) {
//            $subject->messageManager->addErrorMessage(__('We cannot apply the coupon code.'));
//            $subject->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
//        }
//
return $result;
    }
}

