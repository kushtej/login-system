<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Controller\Adminhtml\Details;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
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
        return $this->pageFactory->create();
    }
}
