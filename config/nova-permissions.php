<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User model class
    |--------------------------------------------------------------------------
    */

    'user_model' => 'App\Models\Admin',

    /*
    |--------------------------------------------------------------------------
    | Nova User resource tool class
    |--------------------------------------------------------------------------
    */

    'user_resource' => 'App\Nova\Admin',

    /*
    |--------------------------------------------------------------------------
    | The group associated with the resource
    |--------------------------------------------------------------------------
    */

    'role_resource_group' => 'Other',

    /*
    |--------------------------------------------------------------------------
    | Database table names
    |--------------------------------------------------------------------------
    | When using the "HasRoles" trait from this package, we need to know which
    | table should be used to retrieve your roles. We have chosen a basic
    | default value but you may easily change it to any table you like.
    */

    'table_names' => [
        'roles' => 'roles',

        'role_permission' => 'role_permission',

        'role_user' => 'role_user',

        'users' => 'admins',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        /*
         |--------------------------------------------------------------------------
         | System permissions...
         |--------------------------------------------------------------------------
         */

        'access nova' => [
            'display_name' => 'Access Nova',
            'description' => 'Can access the admin panel',
            'group' => 'System',
        ],

        'access telescope' => [
            'display_name' => 'Access Telescope',
            'description' => 'Can access telescope',
            'group' => 'System',
        ],

        'access horizon' => [
            'display_name' => 'Access Horizon',
            'description' => 'Can access horizon',
            'group' => 'System',
        ],

        /*
         |--------------------------------------------------------------------------
         | Users permissions...
         |--------------------------------------------------------------------------
         */
        'view users' => [
            'display_name' => 'View users',
            'description' => 'Can view users',
            'group' => 'User',
        ],

        'create users' => [
            'display_name' => 'Create users',
            'description' => 'Can create users',
            'group' => 'User',
        ],

        'edit users' => [
            'display_name' => 'Edit users',
            'description' => 'Can edit users',
            'group' => 'User',
        ],

        'delete users' => [
            'display_name' => 'Delete users',
            'description' => 'Can delete users',
            'group' => 'User',
        ],

        'impersonate users' => [
            'display_name' => 'Impersonate users',
            'description' => 'Can impersonate users',
            'group' => 'User',
        ],

        'verify users' => [
            'display_name' => 'Verify users',
            'description' => 'Can verify users',
            'group' => 'User',
        ],

        'access users dashboard' => [
            'display_name' => 'Access Users Dashboard',
            'description' => 'Can users dashboard',
            'group' => 'User',
        ],

        /*
         |--------------------------------------------------------------------------
         | Admins permissions...
         |--------------------------------------------------------------------------
         */
        'view admins' => [
            'display_name' => 'View admins',
            'description' => 'Can view admins',
            'group' => 'Admin',
        ],

        'create admins' => [
            'display_name' => 'Create admins',
            'description' => 'Can create admins',
            'group' => 'Admin',
        ],

        'edit admins' => [
            'display_name' => 'Edit admins',
            'description' => 'Can edit admins',
            'group' => 'Admin',
        ],

        'delete admins' => [
            'display_name' => 'Delete admins',
            'description' => 'Can delete admins',
            'group' => 'Admin',
        ],

        'impersonate admins' => [
            'display_name' => 'Impersonate admins',
            'description' => 'Can impersonate admins',
            'group' => 'Admin',
        ],

        'send admin invitations' => [
            'display_name' => 'Send admin invitations',
            'description' => 'Can send admin invitations',
            'group' => 'Admin',
        ],

        'access admins dashboard' => [
            'display_name' => 'Access Admins Dashboard',
            'description' => 'Can admins dashboard',
            'group' => 'Admin',
        ],

        /*
         |--------------------------------------------------------------------------
         | Roles permissions...
         |--------------------------------------------------------------------------
         */

        'view roles' => [
            'display_name' => 'View roles',
            'description' => 'Can view roles',
            'group' => 'Role',
        ],

        'create roles' => [
            'display_name' => 'Create roles',
            'description' => 'Can create roles',
            'group' => 'Role',
        ],

        'edit roles' => [
            'display_name' => 'Edit roles',
            'description' => 'Can edit roles',
            'group' => 'Role',
        ],

        'delete roles' => [
            'display_name' => 'Delete roles',
            'description' => 'Can delete roles',
            'group' => 'Role',
        ],

        /*
         |--------------------------------------------------------------------------
         | Advertisements...
         |--------------------------------------------------------------------------
         */

        'view advertisements' => [
            'display_name' => 'View advertisements',
            'description' => 'Can view advertisements',
            'group' => 'Advertisement',
        ],

        'create advertisements' => [
            'display_name' => 'Create advertisements',
            'description' => 'Can create advertisements',
            'group' => 'Advertisement',
        ],

        'edit advertisements' => [
            'display_name' => 'Edit advertisements',
            'description' => 'Can edit advertisements',
            'group' => 'Advertisement',
        ],

        'delete advertisements' => [
            'display_name' => 'Delete advertisements',
            'description' => 'Can delete advertisements',
            'group' => 'Advertisement',
        ],

        'access advertisements dashboard' => [
            'display_name' => 'Access Advertisements Dashboard',
            'description' => 'Can advertisements dashboard',
            'group' => 'Advertisement',
        ],

        /*
         |--------------------------------------------------------------------------
         | Country...
         |--------------------------------------------------------------------------
         */

        'view countries' => [
            'display_name' => 'View countries',
            'description' => 'Can view countries',
            'group' => 'Country',
        ],

        'create countries' => [
            'display_name' => 'Create countries',
            'description' => 'Can create countries',
            'group' => 'Country',
        ],

        'edit countries' => [
            'display_name' => 'Edit countries',
            'description' => 'Can edit countries',
            'group' => 'Country',
        ],

        'delete countries' => [
            'display_name' => 'Delete countries',
            'description' => 'Can delete countries',
            'group' => 'Country',
        ],

        'suspend countries' => [
            'display_name' => 'Suspend countries',
            'description' => 'Can suspend countries',
            'group' => 'Country',
        ],

        'activate countries' => [
            'display_name' => 'Activate countries',
            'description' => 'Can activate countries',
            'group' => 'Country',
        ],

        /*
         |--------------------------------------------------------------------------
         | Clicks...
         |--------------------------------------------------------------------------
         */

        'view clicks' => [
            'display_name' => 'View clicks',
            'description' => 'Can view clicks',
            'group' => 'Click',
        ],

        'create clicks' => [
            'display_name' => 'Create clicks',
            'description' => 'Can create clicks',
            'group' => 'Click',
        ],

        'edit clicks' => [
            'display_name' => 'Edit clicks',
            'description' => 'Can edit clicks',
            'group' => 'Click',
        ],

        'delete clicks' => [
            'display_name' => 'Delete clicks',
            'description' => 'Can delete clicks',
            'group' => 'Click',
        ],

        /*
         |--------------------------------------------------------------------------
         | Impressions...
         |--------------------------------------------------------------------------
         */

        'view impressions' => [
            'display_name' => 'View impressions',
            'description' => 'Can view impressions',
            'group' => 'Impression',
        ],

        'create impressions' => [
            'display_name' => 'Create impressions',
            'description' => 'Can create impressions',
            'group' => 'Impression',
        ],

        'edit impressions' => [
            'display_name' => 'Edit impressions',
            'description' => 'Can edit impressions',
            'group' => 'Impression',
        ],

        'delete impressions' => [
            'display_name' => 'Delete impressions',
            'description' => 'Can delete impressions',
            'group' => 'Impression',
        ],

        /*
         |--------------------------------------------------------------------------
         | Club...
         |--------------------------------------------------------------------------
         */

        'view clubs' => [
            'display_name' => 'View clubs',
            'description' => 'Can view clubs',
            'group' => 'Club',
        ],

        'create clubs' => [
            'display_name' => 'Create clubs',
            'description' => 'Can create clubs',
            'group' => 'Club',
        ],

        'edit clubs' => [
            'display_name' => 'Edit clubs',
            'description' => 'Can edit clubs',
            'group' => 'Club',
        ],

        'delete clubs' => [
            'display_name' => 'Delete clubs',
            'description' => 'Can delete clubs',
            'group' => 'Club',
        ],

        'suspend clubs' => [
            'display_name' => 'Suspend clubs',
            'description' => 'Can suspend clubs',
            'group' => 'Club',
        ],

        'activate clubs' => [
            'display_name' => 'Activate clubs',
            'description' => 'Can activate clubs',
            'group' => 'Club',
        ],

        /*
         |--------------------------------------------------------------------------
         | Position...
         |--------------------------------------------------------------------------
         */

        'view positions' => [
            'display_name' => 'View positions',
            'description' => 'Can view positions',
            'group' => 'Position',
        ],

        'create positions' => [
            'display_name' => 'Create positions',
            'description' => 'Can create positions',
            'group' => 'Position',
        ],

        'edit positions' => [
            'display_name' => 'Edit positions',
            'description' => 'Can edit positions',
            'group' => 'Position',
        ],

        'delete positions' => [
            'display_name' => 'Delete positions',
            'description' => 'Can delete positions',
            'group' => 'Position',
        ],

        /*
        |--------------------------------------------------------------------------
        | Privacy policy
        |--------------------------------------------------------------------------
        */

        'view privacy policies' => [
            'display_name' => 'View privacy policies',
            'description' => 'Can view privacy policies',
            'group' => 'Privacy Policy',
        ],

        'create privacy policies' => [
            'display_name' => 'Create privacy policies',
            'description' => 'Can create privacy policies',
            'group' => 'Privacy Policy',
        ],

        'edit privacy policies' => [
            'display_name' => 'Edit privacy policies',
            'description' => 'Can edit privacy policies',
            'group' => 'Privacy Policy',
        ],

        'delete privacy policies' => [
            'display_name' => 'Delete privacy policies',
            'description' => 'Can delete privacy policies',
            'group' => 'Privacy Policy',
        ],

        'publish privacy policies' => [
            'display_name' => 'Publish privacy policies',
            'description' => 'Can publish privacy policies',
            'group' => 'Privacy Policy',
        ],

        /*
        |--------------------------------------------------------------------------
        | Terms and conditions.
        |--------------------------------------------------------------------------
        */

        'view terms and conditions' => [
            'display_name' => 'View terms and conditions',
            'description' => 'Can view terms and conditions',
            'group' => 'Terms and conditions',
        ],

        'create terms and conditions' => [
            'display_name' => 'Create terms and conditions',
            'description' => 'Can create terms and conditions',
            'group' => 'Terms and conditions',
        ],

        'edit terms and conditions' => [
            'display_name' => 'Edit terms and conditions',
            'description' => 'Can edit terms and conditions',
            'group' => 'Terms and conditions',
        ],

        'delete terms and conditions' => [
            'display_name' => 'Delete terms and conditions',
            'description' => 'Can delete terms and conditions',
            'group' => 'Terms and conditions',
        ],

        'publish terms and conditions' => [
            'display_name' => 'Publish terms and conditions',
            'description' => 'Can publish terms and conditions',
            'group' => 'Terms and conditions',
        ],

        /*
        |--------------------------------------------------------------------------
        | Cookie policies.
        |--------------------------------------------------------------------------
        */

        'view cookie policies' => [
            'display_name' => 'View cookie policies',
            'description' => 'Can view cookie policies',
            'group' => 'Cookie Policy',
        ],

        'create cookie policies' => [
            'display_name' => 'Create cookie policies',
            'description' => 'Can create cookie policies',
            'group' => 'Cookie Policy',
        ],

        'edit cookie policies' => [
            'display_name' => 'Edit cookie policies',
            'description' => 'Can edit cookie policies',
            'group' => 'Cookie Policy',
        ],

        'delete cookie policies' => [
            'display_name' => 'Delete cookie policies',
            'description' => 'Can delete cookie policies',
            'group' => 'Cookie Policy',
        ],

        'publish cookie policies' => [
            'display_name' => 'Publish cookie policies',
            'description' => 'Can publish cookie policies',
            'group' => 'Cookie Policy',
        ],

        /*
        |--------------------------------------------------------------------------
        | Ratings.
        |--------------------------------------------------------------------------
        */

        'view ratings' => [
            'display_name' => 'View ratings',
            'description' => 'Can view ratings',
            'group' => 'Rating',
        ],

        'create ratings' => [
            'display_name' => 'Create ratings',
            'description' => 'Can create ratings',
            'group' => 'Rating',
        ],

        'edit ratings' => [
            'display_name' => 'Edit ratings',
            'description' => 'Can edit ratings',
            'group' => 'Rating',
        ],

        'delete ratings' => [
            'display_name' => 'Delete ratings',
            'description' => 'Can delete ratings',
            'group' => 'Rating',
        ],
    ],
];
