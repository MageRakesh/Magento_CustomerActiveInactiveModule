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

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
/**
 * Class Link
 * @package MageRakesh\Customer\Block
 */
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var Session
     */
    private $customer;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * Link constructor.
     * @param Session $customer
     * @param CustomerRepositoryInterface $customerRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Session $customer,
        CustomerRepositoryInterface $customerRepository,
        Context $context,
        array $data = []
    )
{
    $this->customer = $customer;
    $this->customerRepository = $customerRepository;
    parent::__construct($context,$data);

}

    /**
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function customerStatus():string
    {
        $customer = $this->customer;
        $customerId = $customer->getId();
        $customerRep = $this->customerRepository->getById($customerId);

        if ($customerRep->getCustomAttribute('customer_status')) {
                    $status = $customerRep->getCustomAttribute('customer_status')->getValue();
                }else{
                    $status = "";
                }

        if($status == 1){
            $customerStatusValue = "Active Customer";
        }elseif($status == 2){
            $customerStatusValue = "Inactive Customer";

        }else{
            $customerStatusValue = "Status Not Updated";
        }

        return $customerStatusValue;
    }

    /**
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _toHtml():string
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        return '<li><a>' .$this->customerStatus(). '</a></li>';
    }
}
