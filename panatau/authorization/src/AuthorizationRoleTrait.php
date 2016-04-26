<?php
/**
 * Implementation of Role
 * User: toni
 * Date: 16/10/15
 * Time: 21:13
 */

namespace Panatau\Authorization;


trait AuthorizationRoleTrait
{

    /**
     * Create new role
     * @param $roleName String name of Role
     * @param null $desc String description
     * @return Role
     */
    public function createRole($roleName, $desc = null)
    {
        return Role::create([
            'name'=>$roleName,
            'desc'=>$desc
        ]);
    }

    /**
     * Go find role based on the role name
     * @param string $roleName
     * @return Role
     */
    public function getRole($roleName)
    {
        if(is_array($roleName)) return Role::whereIn('nama', $roleName)->get();
        return Role::where('name','=', $roleName)->first();
    }

    /**
     * Delete Role
     * @param String|Role $role
     * @return bool
     */
    public function deleteRole($role)
    {
        $p = is_string($role)?$this->getRole($role):$role;
        return $p->delete();
    }

    /**
     * The $role will inherit all $roleInherit permissions.
     * $role will be higher level than $roleInherit.
     * @param $role Role
     * @param $roleInherit Role
     * @return bool
     */
    public function setRoleInherit($role, $roleInherit)
    {
        if(is_string($role)) $role = $this->getRole($role);
        if(is_string($roleInherit)) $roleInherit = $this->getRole($roleInherit);
        $role->inherit_from_id = $roleInherit->id;
        return $role->save();
    }
}