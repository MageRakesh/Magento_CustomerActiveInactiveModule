<?php
/**
 * MageRakesh
 * Copyright (C) 2020 MageRakesh <rakeshroy78000@gmail.com>
 *
 * @package MageRakesh_Customer
 * @copyright Copyright (c) 2020 MageRakesh_Customer (https://github.com/MageRakesh)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageRakesh <rakeshroy78000@gmail.com>
 */
declare(strict_types=1);

namespace MageRakesh\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class AddCustomerAttribute
 * @package MageRakesh\Customer\Setup\Patch\Data
 */
class AddCustomerAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;

    /**
     * AddCustomerPhoneNumberAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        try {
            $customerSetup->addAttribute(Customer::ENTITY, 'customer_status', [

                'type' => 'int',
                'label' => 'Customer Status',
                'input' => 'select',
                'source' => 'MageRakesh\Customer\Model\Source\Customdropdown',
                'required' => false,
                'sort_order' => 210,
                'visible' => true,
                'system' => false,
                'validate_rules' => '',
                'position' => 210,
                'admin_checkout' => '',
                'option' => ['values' => ['Active', 'Inactive']],
            ]);
        } catch (LocalizedException | \Zend_Validate_Exception $e) {
        }

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'customer_status')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','customer_account_edit']
            ]);
        $attribute->save();
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
