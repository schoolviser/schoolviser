<?php

namespace App;

use Delgont\Auth\PermissionRegistrar;

class EmployeeControlPermissionRegistrar extends PermissionRegistrar
{
    //define your permissions as constants
    const ACCESS_EMPLOYEE_CONTROL_LINKS = 'can_access_employee_control_links';
    const CAN_VIEW_EMPLOYEE_LISTING = 'can_view_employee_listing';
    const CAN_ADD_EMPLOYEE = 'can_add_emloyee';
    const CAN_VIEW_EMPLOYEE_PROFILE = 'can_view_staff_profile';
    const CAN_EDIT_EMPLOYEE_DETAILS = 'can_edit_employee_details';
    const CAN_DELETE_EMPLOYEE_DETAILS = 'can_delete_employee_details';
    const CAN_VIEW_EMPLOYEE_TRASH = 'can_view_employee_trash';
    const CAN_RESTORE_EMPLOYEE_FROM_TRASH = 'can_restore_employee_from_trash';

    const CAN_CREATE_OR_ADD_EMPLOYEE_POSITIONS = 'can_create_or_add_employee_positions';
    const CAN_VIEW_EMPLOYEE_POSITIONS_LISTING = 'can_view_employee_positions_listing';
    const CAN_UPDATE_EMPLOYEE_POSITIONS = 'can_update_employee_positions';
    const CAN_DELETE_EMPLOYEE_POSITIONS = 'can_delete_employee_positions';

    const CAN_IMPORT_EMPLOYEES = 'can_import_employees';

    protected $group = 'Employee Control';

    //permision descriptions
    public function descriptions()
    {
        return [
            self::CAN_VIEW_EMPLOYEE_LISTING => 'User will be able to view the listing of staff or employees',
            self::CAN_VIEW_EMPLOYEE_PROFILE => 'User will be able to view employee profile',
            self::CAN_ADD_EMPLOYEE => 'User will be able to add users',
            self::CAN_EDIT_EMPLOYEE_DETAILS => 'User can edit employee details',
            self::CAN_DELETE_EMPLOYEE_DETAILS => 'User can delete employee details',
            self::CAN_VIEW_EMPLOYEE_TRASH => 'User will be able to acess deleted employee information',
            self::CAN_IMPORT_EMPLOYEES => 'User with this permission will able to import employee data',
        ];
    }
    
}