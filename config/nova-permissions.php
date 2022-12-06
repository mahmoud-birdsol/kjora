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
    ],
];
