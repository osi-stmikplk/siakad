<?php

namespace Stmik;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Stmik\Otorisasi\HasRoleTrait;

class User extends Authenticatable
{
    use HasRoleTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Owner ...
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
