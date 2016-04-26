<?php
/**
 * Authorization Role
 * User: toni
 * Date: 16/10/15
 * Time: 20:35
 */

namespace Panatau\Authorization;


interface AuthorizationRoleInterface
{
    /**
     * Create new role
     * @param $roleName String name of Role
     * @param null $desc String description
     * @return Role
     */
    public function createRole($roleName, $desc=null);

    /**
     * Go find role based on the role name
     * @param string $roleName
     * @return Role
     */
    public function getRole($roleName);

    /**
     * Delete Role
     * @param String|Role $role
     * @return bool
     */
    public function deleteRole($role);

    /**
     * The $role will inherit all $roleInherit permissions.
     * $role will be higher level than $roleInherit.
     * @param $role Role
     * @param $roleInherit Role
     * @return bool
     */
    public function setRoleInherit($role, $roleInherit);
}