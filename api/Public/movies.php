<?php
require_once '../../db/DB.php';
require_once '../../db/UOW.php';
require_once '../Models/UIMovie.php';

if(isset($_SERVER['REQUEST_METHOD'])) {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['director'])) {
            $director = $_GET['director'];
            $results = getByAuthor($director);

            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        }
    }
}

function getByAuthor($author) : array {
    if($author === null) {
        return [];
    }

    $author = strtolower($author);

    $uow = new \db\UOW(\db\DB::getInstance());

    $movies = $uow->getMovies()->select();

    $roles = $uow->getRoles()->select("director");
    $roleId = 0;
    if(count($roles) > 0) {
        $roleId = $roles[0]->getId();
    }
    else {
        return [];
    }

    $results = [];

    foreach ($movies as $movie) {
        $staff = $movie->getStaff();
        if(containsEmployee($staff, $author, $roleId)) {
            $results[] = \Models\UIMovie::getMovie($movie);

        }
    }

    return $results;
}

function containsEmployee($staff, $name, $roleId) : bool {
    if($staff === null || !is_array($staff) || $name === null || $roleId === null) {
        return false;
    }

    foreach($staff as $emp) {
        $person = $emp->getPerson();
        $role = $emp->getRole();

        if($person === null || $role === null) {
            continue;
        }
        if($role->getId() === $roleId && strtolower($person->getName()) === $name) {
            return true;
        }
    }

    return false;
}