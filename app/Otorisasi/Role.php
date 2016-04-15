<?php

namespace Stmik\Otorisasi;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * Hubungan dengan permissions
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Berikan permission kepada Role ini
     * @param Permission $permission
     * @return Model
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
