<?php

namespace Panatau\Authorization;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(\Config::get('authorization.usertable'), 'role_user');
    }

    /**
     * Ingat ini adalah relasi polymorphic many to many!
     */
    public function permissions()
    {
        return $this->morphToMany('\Panatau\Authorization\Permission', 'owner', 'permission_owner');
    }
}
