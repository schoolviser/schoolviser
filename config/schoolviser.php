<?php

return [

  'version' => '1.2.0',

  'school_short_name' => env('APP_NAME', 'schoolviser'),
  'school_name' => env('SCHOOLVISER_SCHOOL_NAME', 'Delgont School Of Nursing & Midwifery'),

  'school_type' => env('SCHOOLVISER_TYPE', 'tertiary'),

  'license_url' => env('SCHOOLVISER_LICENSE_URL'),
  'license_key' => env('SCHOOLVISER_LICENSE_KEY', 'default here'),
  'schoolviser_id' => env('SCHOOLVISER_ID', 'default here'),
  'secrete_key' => env('SCHOOLVISER_SECRETE_KEY', 'default here'),


  'logo' => 'images/logo.svg',


  'admin_layout' => env('ADMIN_LAYOUT', 'admin.layouts.master'),

  //'admin_layout' => 'admin.layouts.horizontal',

 /**
  * School type -> primary, secondary, tertiary
  */
  'type' => 'tertiary',


  'intakes' => [
    '1' => 'January Intake',
    '2' => 'July Intake',
    '3' => 'July Intake',
  ],

  'public_storage' => 'public/storage',

  /**
   * O Level Subjects - Defaults
   */
  'olevel_subjects' => [
    '112' => 'English Language',
    '208' => 'Literature in English',
    '218' => 'Fasihi ya Kiswahili',
    '223' => 'CRE (Christian Living Today)',
    '224' => 'CRE (with traditional African religions)',
    '225' => 'Islamic Religious Education',
    '241' => 'History',
    '273' => 'Geography',
    '285' => 'Political Education',
    '301' => 'Latin',
    '309' => 'German',
    '314' => 'French',
    '335' => 'Luganda',
    '336' => 'Lugha ya Kiswahili',
    '337' => 'Arabic',
    '456' => 'Mathematics',
    '475' => 'Additional Mathematics',
    '500' => 'General Science',
    '527' => 'Agriculture: Principles and Practices',
    '535' => 'Physics',
    '545' => 'Chemistry',
    '553' => 'Biology',
    '610' => 'Art',
    '621' => 'Music',
    '631' => 'Health Education',
    '652' => 'Clothing and Textiles',
    '662' => 'Foods & Nutrition',
    '672' => 'Home Management',
    '732' => 'Woodwork',
    '735' => 'Technical Drawing',
    '742' => 'Metalwork',
    '743' => 'Building Construction',
    '751' => 'Electricity & Electronics',
    '752' => 'Power & Energy',
    '800' => 'Commerce',
    '810' => 'Principles of Accounts',
    '820' => 'Shorthand',
    '831' => 'Typewriting',
    '835' => 'Office Practice',
    '840' => 'Computer Studies',
    '845' => 'Entrepreneurship Skills'
  ],

  /**
   * A Level Subjects - Defaults
   */
  'alevel_subjects' => [
    '000' => 'General Paper',
    '210' => 'History',
    '220' => 'Economics',
    '235' => 'Islamic Religious Education',
    '245' => 'Christian Religious Education',
    '250' => 'Geography',

    // Languages
    '310' => 'Literature in English',
    '320' => 'Kiswahili',
    '330' => 'French',
    '340' => 'German',
    '350' => 'Latin',
    '360' => 'Luganda',
    '370' => 'Arabic',

    // Mathematical Subjects
    '425' => 'Mathematics',
    '475' => 'Mathematics (subsidiary)',

    // Science Subjects
    '510' => 'Physics',
    '515' => 'Agriculture',
    '525' => 'Chemistry',
    '530' => 'Biology',

    // Cultural Subjects and Others
    '610' => 'Art',
    '620' => 'Music',
    '630' => 'Clothing and Textiles',
    '640' => 'Foods and Nutrition',

    // Technical Subjects
    '710' => 'Geometrical and Mechanical Drawing',
    '720' => 'Geometrical and Building Drawing',
    '730' => 'Woodwork',
    '740' => 'Engineering and Metalwork',
  ],

  'courses' => [
      // Nursing School Courses
      'CN' => 'Certificate in Nursing',
      'CM' => 'Certificate in Midwifery',
      'DM' => 'Diploma in Midwifery',
      'DN' => 'Diploma in Nursing',
      'CNA' => 'Certificate in Nursing Assistant',
      'CNM' => 'Certificate in Neonatal Nursing and Midwifery',
      'PN' => 'Post-Basic Nursing',
      'PAM' => 'Post-Basic Anaesthesia and Midwifery',

      // University Courses
      'BCS' => 'Bachelor of Computer Science',
      'BIT' => 'Bachelor of Information Technology',
      'BBA' => 'Bachelor of Business Administration',
      'BAE' => 'Bachelor of Arts in Education',
      'BME' => 'Bachelor of Mechanical Engineering',
      'BEE' => 'Bachelor of Electrical Engineering',
      'BNS' => 'Bachelor of Nursing Science',
      'LLB' => 'Bachelor of Laws',
      'BPH' => 'Bachelor of Public Health',
      'MBA' => 'Master of Business Administration',
      'MSC' => 'Master of Science',
      'MPH' => 'Master of Public Health',
      'PHD' => 'Doctor of Philosophy',
      'MD' => 'Doctor of Medicine',
  ],



   'package' => 'premium',


   /*
    |--------------------------------------------------------------------------
    | ACCESS CONTROL DEFAULTS
    |--------------------------------------------------------------------------
    */
    'roles' => [
      'master' => 'Manages the overall system configuration, user management, and access levels.',
      'admin' => 'Manages the overall system configuration, user management, and access levels.',
      'Head Teacher' => 'Oversees the school’s operations, academic programs, and student discipline.',
      'Academic Registrar' => 'Manages academic-related activities, including curriculum and scheduling.',
    ],

];
