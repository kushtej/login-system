<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Controller\Adminhtml\Details;

use Codilar\CouponModule\Api\DetailsRepositoryInterface;
use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var DetailsRepositoryInterface
     */
    private $detailsRepository;
    /**
     * @var Action\Context
     */
    private $context;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * MassDelete constructor.
     * @param Action\Context $context
     * @param Filter $filter
     * @param DetailsRepositoryInterface $detailsRepository
     * @param CollectionFactory $collectionFactory
     * @param ProductRepository $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        DetailsRepositoryInterface $detailsRepository,
        CollectionFactory $collectionFactory,
        ProductRepository $productRepository,
        SearchCriteriaBuilder$searchCriteriaBuilder
    ) {
        $this->filter = $filter;
        $this->detailsRepository = $detailsRepository;
        $this->context = $context;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $vendorDeleted = 0;
        foreach ($collection->getItems() as $vendor) {
            $search_criteria = $this->searchCriteriaBuilder->addFilter('coupon_name', $vendor['id'])->create();
            $products = $this->productRepository->getList($search_criteria)->getItems();
            foreach ($products as $product) {
                $product->setVendor('0');
                $this->productRepository->save($product);
            }
            $this->detailsRepository->delete($vendor);
            $vendorDeleted++;
        }
        if ($vendorDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $vendorDeleted)
            );
        }
        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}
