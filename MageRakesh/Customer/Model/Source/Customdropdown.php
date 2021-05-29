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
namespace MageRakesh\Customer\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Customdropdown extends AbstractSource
{
    public function getAllOptions(): ?array
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => __('Please Select')],
                ['value' => '1', 'label' => __('Active')],
                ['value' => '2', 'label' => __('Inactive')]
            ];
        }

        return $this->_options;
    }
}
