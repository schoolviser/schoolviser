<?php

namespace App;

use Delgont\Armor\PermissionRegistrar;

class CoursePermissionRegistrar extends PermissionRegistrar
{
    /**
     * Permission group.
     *
     * @var string
     */
    protected $group = 'courses';

    // Permissions for courses
    const CAN_MANAGE_COURSES = 'can_manage_courses';
    const CAN_ADD_COURSE = 'can_add_course';
    const CAN_UPDATE_COURSE = 'can_update_course';
    const CAN_DELETE_COURSE = 'can_delete_course';
    const CAN_VIEW_COURSE = 'can_view_course';

    // Permissions for course groups
    const CAN_MANAGE_COURSE_GROUPS = 'can_manage_course_groups';
    const CAN_ADD_COURSE_GROUP = 'can_add_course_group';
    const CAN_UPDATE_COURSE_GROUP = 'can_update_course_group';
    const CAN_DELETE_COURSE_GROUP = 'can_delete_course_group';
    const CAN_VIEW_COURSE_GROUP = 'can_view_course_group';

    /**
     * Permission descriptions.
     *
     * @return array
     */
    public function descriptions(): array
    {
        return [
            // Course permissions
            self::CAN_MANAGE_COURSES => 'User will be able to manage all aspects of courses.',
            self::CAN_ADD_COURSE => 'User will be able to add new courses.',
            self::CAN_UPDATE_COURSE => 'User will be able to update existing courses.',
            self::CAN_DELETE_COURSE => 'User will be able to delete courses.',
            self::CAN_VIEW_COURSE => 'User will be able to view course details.',

            // Course group permissions
            self::CAN_MANAGE_COURSE_GROUPS => 'User will be able to manage all aspects of course groups.',
            self::CAN_ADD_COURSE_GROUP => 'User will be able to add new course groups.',
            self::CAN_UPDATE_COURSE_GROUP => 'User will be able to update existing course groups.',
            self::CAN_DELETE_COURSE_GROUP => 'User will be able to delete course groups.',
            self::CAN_VIEW_COURSE_GROUP => 'User will be able to view course group details.',
        ];
    }
}
