<?php

namespace Panatau\Authorization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Permission extends Model
{
    protected $table = 'permission';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Roles
     */
    public function roles()
    {
        return $this->morphedByMany('\Panatau\Authorization\Role', 'owner');
    }

    /**
     * users
     */
    public function users()
    {
        return $this->morphedByMany(\Config::get('authorization.usertable'), 'owner');
    }

}
