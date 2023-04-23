<?php

namespace controllers;

abstract class Repository
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public abstract function create($entity);
    public abstract function select(string $searchTxt);
    public abstract function update($entity);
    public abstract function delete($id);
}