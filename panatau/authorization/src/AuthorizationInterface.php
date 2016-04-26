<?php
/**
 * Authorization Contract!
 * User: toni
 * Date: 16/10/15
 * Time: 20:30
 */

namespace Panatau\Authorization;


use Illuminate\Database\Eloquent\Model;

interface AuthorizationInterface
{

    /**
     * Assign Permission to Role
     * @param Permission $permission Model of Permission or Eloquent Collection
     * @param Role $role name of role or Model of Role
     */
    public function assignRolePermission($permission, $role);

    /**
     * dissociate permission from $role
     * @param String|Permission $permission to dissociate
     * @param String|Role $role the role
     * @return bool
     */
    public function dissociatePermission($permission, $role);

    /**
     * Check if $permission allowed base on $roles given
     * @param String|Array $permission permission to check
     * @param RoleModel|Collection $roles of Role to check
     * @return boolean
     */
    public function checkRolePermission($permission, $roles);

    /**
     * Check if $user can do $permission
     * @param Model $user model of user
     * @param $permission
     * @return bool
     */
    public function isUserCan($user, $permission);

    /**
     * Check if current logged user can do $permission
     * @param $permission String permission to check
     * @return boolean
     */
    public function getIsLoggedUserCan($permission);

}