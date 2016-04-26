<?php
/**
 * Created by PhpStorm.
 * User: toni
 * Date: 18/11/15
 * Time: 14:49
 */

namespace Panatau\Authorization;


use Illuminate\Support\Facades\Facade;

class AuthorizationFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'Panatau\Authorization\AuthorizationInterface'; }
}