<?php
require_once 'UserControllerTest.php';
require_once '../orm/controllers/UserRepository.php';
require_once __DIR__ . '\..\orm\DB.php';

$controller = new \tests\UserControllerTest(new \controllers\UserRepository(orm\DB::getInstance()));


$tests = [
    'signUpShortLoginTest' => $controller->signUpShortLoginTest(),
    'signUpLongLoginTest' => $controller->signUpLongLoginTest(),
    'signUpShortPasswordTest' => $controller->signUpShortPasswordTest(),
    'signUpLongPasswordTest' => $controller->signUpLongPasswordTest(),
    'updateSameUserTest' => $controller->updateSameUserTest(),
    'signUpSameUserTest' => $controller->signUpSameUserTest(),
    'signInInvalidPasswordTest' => $controller->signInInvalidPasswordTest(),
    'deleteTest' => $controller->deleteTest()
];

foreach ($tests as $key => $value) {
    echo "$key : " . ($value === true ? 'passed<br />' : 'failed<br />');
}