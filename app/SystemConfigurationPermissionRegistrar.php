<?php

namespace App;

use Delgont\Armor\PermissionRegistrar;

class SystemConfigurationPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'System Configuration';

    //define your permissions as constants
    const CAN_CONFIGURE_SCHOOL_INFO = 'can_configure_school_info';

    //permision descriptions
    public function descriptions()
    {
        return [self::CAN_CONFIGURE_SCHOOL_INFO => 'Permission to configure and manage school information, including details such as name, address, contact information, and other institutional settings'];
    }
    
}