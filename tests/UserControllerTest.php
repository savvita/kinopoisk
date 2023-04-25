<?php

namespace tests;

use objects\User;
require_once '../orm/objects/User.php';

class UserControllerTest
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function signUpShortLoginTest(): bool {
        $entity = new User(0, 'log', 'qwerty');

        return $this->controller->create($entity) === null;
    }

    public function signUpLongLoginTest(): bool {
        $entity = new User(0, 'logssssssssssssssssssssssssssssssssssssss', 'qwerty');

        return $this->controller->create($entity) === null;
    }

    public function signUpShortPasswordTest(): bool {
        $entity = new User(0, 'login', 'log');

        return $this->controller->create($entity) === null;
    }

    public function signUpLongPasswordTest(): bool {
        $entity = new User(0, 'login', 'logssssssssssssssssssssssssssssssssssssss');

        return $this->controller->create($entity) === null;
    }

    public function updateSameUserTest(): bool {
        $entity = new User(1, 'admin', 'admin');

        return $this->controller->update($entity) === null;
    }

    public function signUpSameUserTest(): bool {
        $entity = new User(0, 'admin', 'admin');

        return $this->controller->create($entity) === null;
    }


    public function signInInvalidPasswordTest(): bool {
        $login = 'admin';
        $password = 'admin';
        $entity = $this->controller->select($login);
        if($entity === null || count($entity) === 0) {
            return false;
        }

        return $entity[0]->getPassword() === $password;
    }
    public function deleteTest(): bool {
        $id = -2;
        $res = $this->controller->delete($id);

        return $res === false;
    }

}