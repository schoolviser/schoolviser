<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defauls
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'admin' => 'Manages the overall system configuration, user management, and access levels.',
        'Headd Teacher' => 'Oversees the school’s operations, academic programs, and student discipline.',
        'Academic Registrar' => 'Manages academic-related activities, including curriculum and scheduling.'
    ],


    //specify the type of the school --- primary, secondary, tertiary
    'school_type' => 'secondary',

    /*
    |--------------------------------------------------------------------------
    | Staff Positions In School
    |--------------------------------------------------------------------------
    */

    'primary_levels' => [
        'lower level',
        'upper level'
    ],

    'secondary_levels' => [
        'o level',
        'a level'
    ],


    'courses' => [
        'cn' => 'Certificate In Nursng',
        'cm' => 'Certificate In Midwifery'
    ],

    'staff_positions' => [
        'Webmaster',
        'Registrar',
        'Principal',
        'HeadTeacher',
        'Custodian',
        'Teaching Assistant',
        'Sports Coach',
        'School Buss Driver',
        'It Manager',
        'Secretary',
        'Catering Assistant',
        'Cleaner',
        'ICT Technician',
        'Librian',
        'Library Assistant',
        'Cook'
    ],

    'departments' => [
        'IT Depertment',
        'Accounts',
        'Science & Technology'
    ],

    'avator' => 'images/avator.png',

    'fee_categories' => [
        'Tuition', 'Uniform'
    ],

    'relations' => [
        'father', 'mother', 'sister', 'uncle', 'guardian'
    ],

    
    //Asset Management and deprecuation
    'asset_types' => [
        'Computer Software', 'Buildings', 'Tools & Equipment', 'Furniture, Fixtures & Fittings', 'Computer Equipment', 'Networking Equipement', 'Transportation',
        'Musical Instrument'
    ],

    'asset_status' => [
        [
            'name' => 'Active',
            'flag' => 'In Use',
            'description' => 'Indicates the asset is in service/assigned to an individual'
        ],
        [
            'name' => 'Available',
            'flag' => 'Available for use',
            'description' => 'Indicates it is available to use/assign'
        ],
        [
            'name' => 'Decommissioned',
            'flag' => 'Inactive',
            'description' => 'Indicates the asset is no longer in service and is deemed not usable in the future to UConn, generally due to irreparable damage, malfunction or end of useful life'
        ]
        
        ],

        'asset_accounts' => [
            'Fixed Assets',
            'Current Assets'
        ],

        'chart_of_accounts' => [
            'assets' => [
                //Current Assets
                //name:description>child1|child2:description|chid3>>childchild1
                'current_assets' => [
                    'Inventory',
                    ':>School Fees',
                ],
                'fixed_assets' => [
                    'Furniture, fixtures & equipment',
                    'Land',
                    'Buildings',
                    'Accumulated Depreciation:Depreciation charges based on schedules'
                ]
            ]
            
        ],

        /**
         * Accounting Defauls
         */
        'revenues' => [
            'Parking Space Rent', 
            'Sporting Facilities Hire', 
            'Donations', 
            'Government Grants',
            'Other Revenue'
        ],

        'expenses' => [
            'Academic Costs>:UCE,UACE||ICT Practical Exams',
            'Public Relation>Radio Announcements|Office Airtime|Scholarships|Advertisements|',
            'Software Costs',
            'Students Welfare:',
            'Bank Fees',
            'Rent',
            'Travel',
            'Wages & Salaries',
            'Telephone & Internet',
            'Computers & IT',
            'Uniform Costs>Skirts|Bloouses|Shirts,Sweaters',
            'Advertising',
            'Printing & Stationery>Equipments:Stapplers,Clips, Other stationery Equipments',
            'Cleaning',
            'Light, Power & Heating',
            'Students Entertainment>Dstv|Music, Dance & Drama|Sports|Other Costs In Relation to entertainment'
        ]
    
];
