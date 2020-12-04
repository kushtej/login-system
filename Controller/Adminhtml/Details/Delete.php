<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Controller\Adminhtml\Details;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Model\Details;
use Codilar\CouponModule\Model\ResourceModel\DetailsFactory as ResourceModel;
use Exception;
use Magento\Backend\App\Action;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @var ResourceModel
     */
    private $detailsResource;
    /**
     * @var Details
     */
    private $details;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param ResourceModel $detailsFactory
     * @param DetailsRepositoryInterface $detailsRepository
     * @param ProductRepository $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Details $details
     */
    public function __construct(
        Action\Context $context,
        ResourceModel $detailsFactory,
        DetailsRepositoryInterface $detailsRepository,
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Details $details
    ) {
        parent::__construct($context);
        $this->detailsResource = $detailsFactory->create();
        $this->details = $details;
        $this->detailsRepository = $detailsRepository;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
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
        $id = $this->getRequest()->getParam('id');
        $search_criteria = $this->searchCriteriaBuilder->addFilter('coupon_name', $id)->create();
        $products = $this->productRepository->getList($search_criteria)->getItems();
        try {
            $model = $this->detailsRepository->load($id);
            foreach ($products as $product) {
                $product->setCouponName('0');
                $this->productRepository->save($product);
            }
            $this->detailsRepository->delete($model);
            $this->messageManager->addSuccessMessage('Coupon successfully deleted');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Error deleting Coupon');
        }
        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}
