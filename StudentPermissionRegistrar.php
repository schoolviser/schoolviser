<?php

namespace Modules\Schoolviser;

use Delgont\Armor\PermissionRegistrar;


class StudentPermissionRegistrar extends PermissionRegistrar
{
    protected $group = 'Manage Students';

    const CAN_MANAGE_STUDENTS_INFO = 'can_manage_students_info';
    const CAN_VIEW_STUDENTS_LISTING = 'can_view_students_listing';
    const CAN_VIEW_STUDENT_PROFILE = 'can_view_students_profile';
    const CAN_VIEW_INDIVIDUAL_STUDENT_INFO = 'can_view_individual_students_info';
    const CAN_REGISTER_STUDENT = 'can_register_student';
    const CAN_DELETE_STUDENT_INFO = 'can_delete_student_info';
    const CAN_VIEW_DELETED_STUDENTS = 'can_view_deleted_students';
    const CAN_RESTORE_DELETED_STUDENTS = 'can_restore_deleted_students';
    const CAN_PERMANENTLY_DELETE_STUDENTS = 'can_permanently_delete_students';
    const CAN_UPDATE_STUDENTS_PERSONAL_INFO = 'can_update_students_personal_info';
    const CAN_UPDATE_STUDENTS_REGISTRATION_INFO = 'can_update_students_registration_info';
    const CAN_LOCK_STUDENT_REGISTRATION = 'can_lock_student_registration';
    const CAN_UNLOCK_STUDENT_REGISTRATION = 'can_unlock_student_registration';
    const CAN_UPDATE_STUDENTS_PHOTO = 'can_update_students_photo';
    const CAN_IMPORT_STUDENTS_INFO = 'can_import_students_info';


    public function descriptions() : array
    {
        return [
         self::CAN_MANAGE_STUDENTS_INFO => 'User will be able to magae students info',
         self::CAN_VIEW_STUDENTS_LISTING => 'User will be able to view students listing table',
         self::CAN_VIEW_INDIVIDUAL_STUDENT_INFO => 'Grants access to detailed information about individual students, including personal details, academic records, and attendance history within the student module.',
         self::CAN_REGISTER_STUDENT => 'User will be able to register or add student',
         self::CAN_DELETE_STUDENT_INFO => 'User will be able to delete student info',
         self::CAN_VIEW_DELETED_STUDENTS => 'User will be able to view students in the trash',
         self::CAN_RESTORE_DELETED_STUDENTS => 'User will be able to view students in the trash',
         self::CAN_PERMANENTLY_DELETE_STUDENTS => 'User will be able to permanently delete students',
         self::CAN_UPDATE_STUDENTS_PERSONAL_INFO => 'User will be able to update students personal info',
         self::CAN_UPDATE_STUDENTS_REGISTRATION_INFO => 'User will be able to update students registration info',
        ];
    }

}
