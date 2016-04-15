<?php
/**
 * Utility untuk mengatur role dll
 * User: toni
 * Date: 14/04/16
 * Time: 21:58
 */

namespace Stmik\Otorisasi;


trait HasRoleTrait
{

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission|String $permission
     * @return boolean
     */
    public function hasPermission($permission)
    {
        if(is_string($permission)) {
            return $this->hasRole(Permission::whereName($permission)->firstOrFail()->roles);
        }
        return $this->hasRole($permission->roles);
    }

}