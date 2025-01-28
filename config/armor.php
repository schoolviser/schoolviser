<?php

return [

    'add_usertype_to_users_model' => true,


    /**
     * Permission COnfiguratiin
     */
    'permission_delimiter' => '|',

    'permission_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      App\DashboardPermissionRegistrar::class,
      App\MomoPermissionRegistrar::class,
      App\SystemConfigurationPermissionRegistrar::class,
      Modules\User\UserPermissionRegistrar::class,
      App\CoursePermissionRegistrar::class
    ],

    /**
     * Role Configuration
     */

    'role_delimiter' => '|',

    'role_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      App\Roles\ExampleRoleRegistrar::class,
    ],

    'role_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      App\Roles\ExampleRoleRegistrar::class,

      'redirect_suspended' => 'hello'
    ],

    'user' => \Modules\User\Entities\User::class

];
