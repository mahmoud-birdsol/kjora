<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Suspensions database table name...
     |--------------------------------------------------------------------------
     |
     | You can change the suspensions records table name here
     | a sensible default has been set.
     */

    'table_name' => 'suspensions',

    /*
     |--------------------------------------------------------------------------
     | Enum values for suspended and activated records.
     |--------------------------------------------------------------------------
     |
     | You can change the default constants for enum values but make sure that
     | those are updated before running the migration in the database since
     | this will be persisted.
     */

    'suspended' => 'suspended',
    'activated' => 'reinstated',
];
