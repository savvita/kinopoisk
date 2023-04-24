<?php

namespace db;

require_once 'DB.php';
require_once 'Controllers\CategoryRepository.php';
require_once 'Controllers\RoleRepository.php';
require_once 'Controllers\PersonRepository.php';
require_once 'Controllers\MovieRepository.php';

class UOW
{
    private $categories;
    private $roles;
    private $people;
    private $movies;
    public function __construct($db)
    {
        $this->categories = new \controllers\CategoryRepository($db);
        $this->roles = new \controllers\RoleRepository($db);
        $this->people = new \controllers\PersonRepository($db);
        $this->movies = new \controllers\MovieRepository($db);
    }

    public function getCategories() {
        return $this->categories;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getPeople() {
        return $this->people;
    }

    public function getMovies() {
        return $this->movies;
    }
}