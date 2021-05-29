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
namespace MageRakesh\Customer\Controller\Customer;

use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class SaveCustomerStatus
 * @package MageRakesh\Customer\Controller\Customer
 */
class SaveCustomerStatus extends Action
{

    /**
     * @var PageFactory
     */
    private $resultPageFactory;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var CustomerFactory
     */
    private $customerFactory;
    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;
    /**
     * @var Session
     */
    private $customerSession;
    /**
     * @var ManagerInterface
     */
    private $_messageManager;
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * SaveCustomerStatus constructor.
     * @param ResultFactory $resultFactory
     * @param Session $customerSession
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Customer $customer
     * @param CustomerFactory $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param ManagerInterface $messageManager
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResultFactory $resultFactory,
        Session $customerSession,
        Context $context,
        PageFactory $resultPageFactory,
        Customer $customer,
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        ManagerInterface $messageManager,
        StoreManagerInterface $storeManager
    )
    {
        $this->resultFactory = $resultFactory;
        $this->customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->customer = $customer;
        $this->customerFactory = $customerFactory;
        $this->_customerRepository = $customerRepository;
        $this->_messageManager = $messageManager;
        $this->_storeManager = $storeManager;
        return parent::__construct($context);
    }

    /**
     * @return Redirect
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            if ($data['customer_status']['0'] !='') {
                $customerId = $this->customerSession->getId();
                $customerStatusValue = $data['customer_status']['0'];
                $customer = $this->_customerRepository->getById($customerId);
                $customer->setCustomAttribute('customer_status',$customerStatusValue);
                $this->_customerRepository->save($customer);

                $this->_messageManager->addSuccessMessage(__("Status updated successfully."));
                }
            } catch (Exception $e) {
            $this->_messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $baseUrl.'customer/customer/index/';
        $resultRedirect->setUrl($url);

        return $resultRedirect;

    }
}
