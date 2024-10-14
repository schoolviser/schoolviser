<?php

return [

  'school_name' => 'Delgont Primary School',
  
  'logo' => 'images/logo.svg',

  'version' => env('APP_VERSION', 'Dev'),

  'admin_layout' => env('ADMIN_LAYOUT', 'admin.layouts.master'),

  //'admin_layout' => 'admin.layouts.horizontal',

 /**
  * School type -> primary, secondary, tertiary
  */

  'type' => 'tertiary',

  'intakes' => [
    '1' => 'Jan Intake',
    '2' => 'July Intake',
    '3' => 'Configure Intage Name'
  ],

  'public_storage' => 'public/storage',


   'modules' => [
    //'student',
    //'fee',
    //'accounting',
    //'requisition',
    //'admission',
    'course',
    //'applicant',
    'user'
   ],


   'package' => 'premium'

];