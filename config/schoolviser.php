<?php

return [


  'school_name' => 'Delgont Memorial School Of Nursing & Midwifery',

  
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


  //Module Settings
   'modules' => [
   ],

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
    'CN' => 'Certificate Nursing',
    'CM' => 'Certificate Midwifery'
   ],


   'package' => 'premium',

   'version' => 'v0.7.2'

];