<?php

namespace db;

require_once 'db/DB.php';
require_once 'db/Controllers/CategoryRepository.php';
require_once 'db/Controllers/RoleRepository.php';
require_once 'db/Controllers/PersonRepository.php';
require_once 'db/Controllers/MovieRepository.php';

class UOW
{
    private $categories;
    private $roles;
    private $people;
    private $mpvoes;
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