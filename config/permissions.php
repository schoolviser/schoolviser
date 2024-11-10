<?php

return [
    'delimiter' => '|',

    'permission_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      //App\DashboardPermissionRegistrar::class,
      //App\AccountingPermissionRegistrar::class,
      //App\AssetPermissionRegistrar::class,
      App\SystemPermissionRegistrar::class,
      App\SystemSettingsPermissionRegistrar::class,
      //App\FeesPermissionRegistrar::class,
      //App\LibraryPermissionRegistrar::class,

      /**
       * Module Level Permission Registrar
       */
      Modules\User\UserPermissionRegistrar::class,
      Modules\Student\StudentPermissionRegistrar::class,
      Modules\Requisition\RequisitionPermissionRegistrar::class,
    ]

   
];