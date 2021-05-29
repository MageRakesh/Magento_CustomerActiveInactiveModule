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

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package MageRakesh\Customer\Controller\Customer
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $_pageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    /**
     * @return Page|ResultInterface
     */
    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
