<?php

namespace App;

use Delgont\Armor\PermissionRegistrar;

class DashboardPermissionRegistrar extends PermissionRegistrar
{

    protected $group = 'Dashboard';

    const CAN_VIEW_STUDENT_TOTALS = 'can_view_student_totals';
    const CAN_VIEW_STUDENTS_PER_CLASS_BAR_CHART = 'can_view_students_per_class_bar_chart';

    //permision descriptions
    public function descriptions() : array
    {
        return [];
    }

}
