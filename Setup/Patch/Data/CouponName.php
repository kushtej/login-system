<?php

/**
 * @package CouponModule
 */
namespace Codilar\CouponModule\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class CouponModule
 * @package Codilar\CouponModule\Setup\Patch\Data
 */
class CouponName implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * CouponName constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return '2.7';
    }
    /**
     * @inheritDoc
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'coupon_name',
            [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Vendor Name',
                'input' => 'select',
                'note' => 'Sold By',
                'class' => '',
                'source' => 'Codilar\CouponModule\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'option' => [
                    'values' => [],
                ]
            ]
        );
    }
}
