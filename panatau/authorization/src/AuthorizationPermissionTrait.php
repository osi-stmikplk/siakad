<?php
/**
 * Set permission
 * User: toni
 * Date: 16/10/15
 * Time: 21:02
 */

namespace Panatau\Authorization;


use Illuminate\Database\Eloquent\Collection;

trait AuthorizationPermissionTrait
{
    /**
     * Create new role
     * @param $permissionName String name of Permission
     * @param null $desc String description
     * @return Permission
     */
    public function createPermission($permissionName, $desc = null)
    {
        return Permission::create([
            'name'=>$permissionName,
            'desc'=>$desc
        ]);
    }

    /**
     * Go find role based on the role name
     * @param array|string $permissionName
     * @return Permission|Collection
     */
    public function getPermission($permissionName)
    {
        if(is_array($permissionName))
        {
            return Permission::whereIn('name', $permissionName)->get();
        }
        return Permission::where('name','=',$permissionName)->first();
    }

    /**
     * Delete Permission
     * @param String|Permission $permission
     * @return bool
     */
    public function deletePermission($permission)
    {
        $p = is_string($permission)?$this->getPermission($permission):$permission;
        return $p->delete();
    }
}