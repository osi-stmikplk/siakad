<?php
/**
 * Ditambahkan oleh User untuk relasi terhadap Authorization
 * User: toni
 * Date: 16/10/15
 * Time: 20:18
 */

namespace Panatau\Authorization;


trait UserAuthorizationTrait
{

    /**
     * Relasi terhadap roles
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('\Panatau\Authorization\Role', 'role_user');
    }

    /**
     * Ingat ini adalah relasi polymorphic many to many!
     */
    public function permissions()
    {
        return $this->morphToMany('\Panatau\Authorization\Permission', 'owner', 'permission_owner');
    }

    /**
     * Add Role to user
     * @param string|Role $role name of role or model of role!
     */
    public function addRole($role)
    {
        /** @var Authorization $a */
        $a = app('Panatau\Authorization\AuthorizationInterface');
        $r = $role instanceof Role? $role: $a->getRole($role);
        return $this->roles()->attach($r);
    }

    /**
     * Remove Role from current User
     * @param string|Role $role name or role or model of role
     * @return bool
     */
    public function removeRole($role)
    {
        /** @var Authorization $a */
        $a = app('Panatau\Authorization\AuthorizationInterface');
        $r = $role instanceof Role? $role: $a->getRole($role);
        return $this->roles()->detach($r) > 0;
    }

    /**
     * Check if user have role as ...
     * @param string $role role name
     * @return bool
     */
    public function isRoleAs($role)
    {
        return $this->roles()->where('role.name','=',$role)->count() > 0;
    }

    /**
     * Check if current user have permission
     * @param $permission
     * @return bool
     */
    public function isAbleTo($permission)
    {
        /** @var Authorization $a */
        $a = app('Panatau\Authorization\AuthorizationInterface');
        return $a->isUserCan($this, $permission);
    }

}