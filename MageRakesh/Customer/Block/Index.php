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
namespace MageRakesh\Customer\Block;

use Magento\Customer\Model\SessionFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Class Index
 * @package MageRakesh\Customer\Block
 */
class Index extends Template
{
    protected $customerRepository;
    /**
     * @var Config
     */
    private $eavConfig;
    /**
     * @var SessionFactory
     */
    private $customerSession;
    /**
    /**
     * Index constructor.
     * @param SessionFactory $customerSession
     * @param Config $eavConfig
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        SessionFactory $customerSession,
        Config $eavConfig,
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    )
    {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->eavConfig = $eavConfig;
        parent::__construct($context,$data);
    }

    /**
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCustomerStatusValue()
    {
        $sessionModel = $this->customerSession->create();
        $customerId = $sessionModel->getCustomer()->getId();
        $customer = $this->customerRepository->getById($customerId);
         if ($customer->getCustomAttribute('customer_status')) {
        return $customer->getCustomAttribute('customer_status')->getValue();
                }else{
             return "";
                }
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getOptionList(): array
    {
        $attribute = $this->eavConfig->getAttribute('customer', 'customer_status');
        return $attribute->getSource()->getAllOptions();
    }
}
