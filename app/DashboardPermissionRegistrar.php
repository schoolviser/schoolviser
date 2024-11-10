<?php

namespace App;

use Delgont\Armor\PermissionRegistrar;

class DashboardPermissionRegistrar extends PermissionRegistrar
{

    protected $group = 'Dashboard';
    
    //define your permissions as constants
    const CAN_VIEW_STUDENT_TOTALS = 'can_view_student_totals';
    const CAN_VIEW_STUDENTS_PER_CLASS_BAR_CHART = 'can_view_students_per_class_bar_chart';

    //permision descriptions
    public function descriptions()
    {
        //return [self::CAN_VIEW_USERS => 'User will be able to view user accounts];
    }
    
}