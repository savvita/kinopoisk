<?php

namespace orm;

require_once 'orm/DB.php';
require_once 'orm/controllers/CategoryRepository.php';
require_once 'orm/controllers/RoleRepository.php';
require_once 'orm/controllers/PersonRepository.php';
require_once 'orm/controllers/MovieRepository.php';

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