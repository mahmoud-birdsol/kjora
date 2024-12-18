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

        /*
       |--------------------------------------------------------------------------
       | Rating Categories.
       |--------------------------------------------------------------------------
       */

        'view rating categories' => [
            'display_name' => 'View rating categories',
            'description' => 'Can view rating categories',
            'group' => 'Rating Category',
        ],

        'create rating categories' => [
            'display_name' => 'Create rating categories',
            'description' => 'Can create rating categories',
            'group' => 'Rating Category',
        ],

        'edit rating categories' => [
            'display_name' => 'Edit rating categories',
            'description' => 'Can edit rating categories',
            'group' => 'Rating Category',
        ],

        'delete rating categories' => [
            'display_name' => 'Delete rating categories',
            'description' => 'Can delete rating categories',
            'group' => 'Rating Category',
        ],

        /*
        |--------------------------------------------------------------------------
        | Labels.
        |--------------------------------------------------------------------------
        */

        'view labels' => [
            'display_name' => 'View labels',
            'description' => 'Can view labels',
            'group' => 'Label',
        ],

        'create labels' => [
            'display_name' => 'Create labels',
            'description' => 'Can create labels',
            'group' => 'Label',
        ],

        'edit labels' => [
            'display_name' => 'Edit labels',
            'description' => 'Can edit labels',
            'group' => 'Label',
        ],

        'delete labels' => [
            'display_name' => 'Delete labels',
            'description' => 'Can delete labels',
            'group' => 'Label',
        ],

        /*
        |--------------------------------------------------------------------------
        | Socials.
        |--------------------------------------------------------------------------
        */

        'view socials' => [
            'display_name' => 'View socials',
            'description' => 'Can view socials',
            'group' => 'Social',
        ],

        'create socials' => [
            'display_name' => 'Create socials',
            'description' => 'Can create socials',
            'group' => 'Social',
        ],

        'edit socials' => [
            'display_name' => 'Edit socials',
            'description' => 'Can edit socials',
            'group' => 'Social',
        ],

        'delete socials' => [
            'display_name' => 'Delete socials',
            'description' => 'Can delete socials',
            'group' => 'Social',
        ],

        'suspend socials' => [
            'display_name' => 'Suspend socials',
            'description' => 'Can suspend socials',
            'group' => 'Social',
        ],

        'activate socials' => [
            'display_name' => 'Activate socials',
            'description' => 'Can activate socials',
            'group' => 'Social',
        ],

        /*
        |--------------------------------------------------------------------------
        | Conversation.
        |--------------------------------------------------------------------------
        */

        'view conversations' => [
            'display_name' => 'View conversations',
            'description' => 'Can view conversations',
            'group' => 'Chat',
        ],

        'create conversations' => [
            'display_name' => 'Create conversations',
            'description' => 'Can create conversations',
            'group' => 'Chat',
        ],

        'edit conversations' => [
            'display_name' => 'Edit conversations',
            'description' => 'Can edit conversations',
            'group' => 'Chat',
        ],

        'delete conversations' => [
            'display_name' => 'Delete conversations',
            'description' => 'Can delete conversations',
            'group' => 'Chat',
        ],

        'suspend conversations' => [
            'display_name' => 'Suspend conversations',
            'description' => 'Can suspend conversations',
            'group' => 'Chat',
        ],

        'activate conversations' => [
            'display_name' => 'Activate conversations',
            'description' => 'Can activate conversations',
            'group' => 'Chat',
        ],

        /*
        |--------------------------------------------------------------------------
        | Messages.
        |--------------------------------------------------------------------------
        */

        'view messages' => [
            'display_name' => 'View messages',
            'description' => 'Can view messages',
            'group' => 'Message',
        ],

        'create messages' => [
            'display_name' => 'Create messages',
            'description' => 'Can create messages',
            'group' => 'Message',
        ],

        'edit messages' => [
            'display_name' => 'Edit messages',
            'description' => 'Can edit messages',
            'group' => 'Message',
        ],

        'delete messages' => [
            'display_name' => 'Delete messages',
            'description' => 'Can delete messages',
            'group' => 'Message',
        ],

        'suspend messages' => [
            'display_name' => 'Suspend messages',
            'description' => 'Can suspend messages',
            'group' => 'Message',
        ],

        'activate messages' => [
            'display_name' => 'Activate messages',
            'description' => 'Can activate messages',
            'group' => 'Message',
        ],

        /*
        |--------------------------------------------------------------------------
        | Comments.
        |--------------------------------------------------------------------------
        */

        'view comments' => [
            'display_name' => 'View comments',
            'description' => 'Can view comments',
            'group' => 'Message',
        ],

        'create comments' => [
            'display_name' => 'Create comments',
            'description' => 'Can create comments',
            'group' => 'Message',
        ],

        'edit comments' => [
            'display_name' => 'Edit comments',
            'description' => 'Can edit comments',
            'group' => 'Message',
        ],

        'delete comments' => [
            'display_name' => 'Delete comments',
            'description' => 'Can delete comments',
            'group' => 'Message',
        ],

        'suspend comments' => [
            'display_name' => 'Suspend comments',
            'description' => 'Can suspend comments',
            'group' => 'Message',
        ],

        'activate comments' => [
            'display_name' => 'Activate comments',
            'description' => 'Can activate comments',
            'group' => 'Message',
        ],

        /*
       |--------------------------------------------------------------------------
       | Report Options.
       |--------------------------------------------------------------------------
       */

        'view report option' => [
            'display_name' => 'View report option',
            'description' => 'Can view report option',
            'group' => 'Report Option',
        ],

        'create report option' => [
            'display_name' => 'Create report option',
            'description' => 'Can create report option',
            'group' => 'Report Option',
        ],

        'edit report option' => [
            'display_name' => 'Edit report option',
            'description' => 'Can edit report option',
            'group' => 'Report Option',
        ],

        'delete report option' => [
            'display_name' => 'Delete report option',
            'description' => 'Can delete report option',
            'group' => 'Report Option',
        ],

        /*
      |--------------------------------------------------------------------------
      | Reports.
      |--------------------------------------------------------------------------
      */

        'view report' => [
            'display_name' => 'View report',
            'description' => 'Can view report',
            'group' => 'Report',
        ],

        'create report' => [
            'display_name' => 'Create report',
            'description' => 'Can create report',
            'group' => 'Report',
        ],

        'edit report' => [
            'display_name' => 'Edit report',
            'description' => 'Can edit report',
            'group' => 'Report',
        ],

        'delete report' => [
            'display_name' => 'Delete report',
            'description' => 'Can delete report',
            'group' => 'Report',
        ],

        'resolve report' => [
            'display_name' => 'Resolve report',
            'description' => 'Can resolve report',
            'group' => 'Report',
        ],

        /*
      |--------------------------------------------------------------------------
      | Reviews.
      |--------------------------------------------------------------------------
      */

        'view reviews' => [
            'display_name' => 'View reviews',
            'description' => 'Can view reviews',
            'group' => 'Review',
        ],

        'create reviews' => [
            'display_name' => 'Create reviews',
            'description' => 'Can create reviews',
            'group' => 'Review',
        ],

        'edit reviews' => [
            'display_name' => 'Edit reviews',
            'description' => 'Can edit reviews',
            'group' => 'Review',
        ],

        'delete reviews' => [
            'display_name' => 'Delete reviews',
            'description' => 'Can delete reviews',
            'group' => 'Review',
        ],

        'resolve reviews' => [
            'display_name' => 'Resolve reviews',
            'description' => 'Can resolve reviews',
            'group' => 'Review',
        ],

        /*
      |--------------------------------------------------------------------------
      | Contact Permissions.
      |--------------------------------------------------------------------------
      */

        'view contacts' => [
            'display_name' => 'View contacts',
            'description' => 'Can view contacts',
            'group' => 'Contacts',
        ],

        'create contacts' => [
            'display_name' => 'Create contacts',
            'description' => 'Can create contacts',
            'group' => 'Contacts',
        ],

        'edit contacts' => [
            'display_name' => 'Edit contacts',
            'description' => 'Can edit contacts',
            'group' => 'Contacts',
        ],

        'delete contacts' => [
            'display_name' => 'Delete contacts',
            'description' => 'Can delete contacts',
            'group' => 'Contacts',
        ],

        'receive contact notifications' => [
            'display_name' => 'Receive contact notifications',
            'description' => 'Can Receive contact notifications',
            'group' => 'Contacts',
        ],
        /*
       |--------------------------------------------------------------------------
       | Likes.
       |--------------------------------------------------------------------------
       */

        'view likes' => [
            'display_name' => 'View likes',
            'description' => 'Can view likes',
            'group' => 'Like',
        ],

        'create likes' => [
            'display_name' => 'Create likes',
            'description' => 'Can create likes',
            'group' => 'Like',
        ],

        'edit likes' => [
            'display_name' => 'Edit likes',
            'description' => 'Can edit likes',
            'group' => 'Like',
        ],

        'delete likes' => [
            'display_name' => 'Delete likes',
            'description' => 'Can delete likes',
            'group' => 'Like',
        ],
    ],
];
