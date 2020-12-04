<?php
/**
 * @package     CouponModule
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @coupon_rule        http://www.codilar.com/
 */
namespace Codilar\CouponModule\Block;

use Codilar\CouponModule\Model\ResourceModel\Details\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\SessionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

class CouponName extends Template
{
    /**
     * @var SessionFactory
     */
    protected $productSession;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Description constructor.
     * @param Template\Context $context
     * @param SessionFactory $productSession
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        SessionFactory $productSession,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->productSession = $productSession;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getDetails()
    {
        $currentProductId = $this->productSession->create()->getData('last_viewed_product_id');
        $product = $this->productRepository->getById($currentProductId);
        $collection = $this->collectionFactory->create()->addFieldToFilter('id', $product->getCouponName())->getData();
        $data['id'] = $product->getCouponName();
        if ($data['id']==='0') {
            $data['error'] = 'no vendor available';
            return $data;
        } else {
            foreach ($collection as $item) {
                $data['coupon_name'] = $item['coupon_name'];
                $data['coupon_rule'] = $item['coupon_rule'];
            }
            return $data;
        }
    }
}
