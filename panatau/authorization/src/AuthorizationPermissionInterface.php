<?php
/**
 * Permission Contract!
 * User: toni
 * Date: 16/10/15
 * Time: 20:50
 */

namespace Panatau\Authorization;


use Illuminate\Database\Eloquent\Collection;

interface AuthorizationPermissionInterface
{
    /**
     * Create new role
     * @param $permissionName String name of Permission
     * @param null $desc String description
     * @return Permission
     */
    public function createPermission($permissionName, $desc=null);

    /**
     * Go find role based on the role name
     * @param array|string $permissionName
     * @return Permission|Collection
     */
    public function getPermission($permissionName);

    /**
     * Delete Permission
     * @param String|Permission $permission
     * @return bool
     */
    public function deletePermission($permission);
}