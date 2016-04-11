<?php
/**
 * Untuk berkaitan dengan User manajement
 * User: toni
 * Date: 11/04/16
 * Time: 12:28
 */

namespace Stmik\Http\Controllers\Auth;


use Stmik\Factories\UserFactory;
use Stmik\Http\Controllers\Controller;

class UserController extends  Controller
{

    /** @var UserFactory  */
    protected $factory;

    public function __construct(UserFactory $userFactory)
    {
        $this->factory = $userFactory;
    }


}