<?php
/**
 * Authorization!
 * TODO: User can get permission without need to have specific Role!
 * User: toni
 * Date: 16/10/15
 * Time: 21:24
 */

namespace Panatau\Authorization;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Authorization implements AuthorizationRoleInterface, AuthorizationPermissionInterface, AuthorizationInterface
{
    use AuthorizationRoleTrait, AuthorizationPermissionTrait;

    /**
     * Get array of permission id
     * @param string|array|Collection|Permission $permission the name of $permission or array of name $permission
     * @return array
     */
    protected function getPermissionIds($permission)
    {
        $ids = [];
        if(is_string($permission) || is_array($permission))
        {
            $p = $this->getPermission($permission);
        }
        else $p = $permission;

        if($p instanceof Collection) {
            $ids = $p->lists('id')->all(); // return array of id
        } else {
            $ids = [ $p->id ]; // convert to array :D
        }
        return $ids;
    }

    /**
     * Assign Permission to Role
     * @param string|array|Collection|Permission $permission the name of $permission or array of name $permission
     * @param string|Role $role name of role
     */
    public function assignRolePermission($permission, $role)
    {
        $ids = $this->getPermissionIds($permission);
        if(is_string($role)) $role = $this->getRole($role);
        // get already assigned permission
        $idp = $role->permissions()->get(['permission.id'])->lists('id')->all();
        // get ids value that are not in the idp
        $toadd = array_diff($ids, $idp);
        if(count($toadd)>0) $role->permissions()->attach($toadd);
    }

    /**
     * dissociate permission from $role
     * @param String|Permission $permission to dissociate
     * @param String|Role $role the role
     * @return bool
     */
    public function dissociatePermission($permission, $role)
    {
        $ids = $this->getPermissionIds($permission);
        if(is_string($role)) $role = $this->getRole($role);
        return $role->permissions()->detach($ids) > 0;
    }

    /**
     * Check if $permission allowed base on $roles given
     * @param String|Array $permission permission to check
     * @param String|Role|Collection $roles of Role to check
     * @return boolean
     */
    public function checkRolePermission($permission, $roles)
    {
        $ret = false;
//        $roles->permissions()->wherePivot('permission_id')
        if(is_string($roles) || is_array($roles))
        {
            $roles = $this->getRole($roles);
        }
        if($roles instanceof Role)
        {
            $rr = [$roles];
        }
        else $rr = $roles;
        // get id permission
        $permToCheck = $this->getPermissionIds($permission);
        foreach ($rr as $r) {
            $permCurrRole = $r->permissions()->get(['permission.id'])->lists('id')->all();
            // check if permissions to check are in the current role permissions using array intersect
            // actually if exists then there is element(s) in permToCheck also existed in permCurrRole
            $b = array_intersect($permToCheck, $permCurrRole);
            // if exists?
            if(count($b)<=0)
            {
                // beware of inherited Role ...
                if($r->inherit_from_id!==null)
                {
                    // recursive call ...
                    $ret = $this->checkRolePermission(
                        $permission, Role::find($r->inherit_from_id)
                    );
                }
            } else $ret = true;
            // break if it found
            if($ret) break;
        }

        return $ret;
    }

    /**
     * Check if $user can do $permission
     * @param Model $user model of user
     * @param $permission
     * @return bool
     */
    public function isUserCan($user, $permission)
    {
        $role = $user->roles;
        return $this->checkRolePermission($permission, $role);
    }

    /**
     * Check if current logged user can do $permission
     * @param $permission String permission to check
     * @return boolean
     */
    public function getIsLoggedUserCan($permission)
    {
        if(\Auth::guest()) return false;
        return $this->isUserCan(\Auth::user(), $permission);
    }

    /**
     * Check if current logged user have role as ..
     * @param $role
     * @return bool
     */
    public function getIsLoggedUserRoleAs($role)
    {
        if(\Auth::guest()) return false;
        return \Auth::user()->isRoleAs($role);
    }
}