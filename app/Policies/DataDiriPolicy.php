<?php

namespace Stmik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DataDiriPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
