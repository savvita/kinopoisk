<?php

namespace controllers;
use models;
require_once __DIR__ . '\..\Models\Category.php';
require_once 'Repository.php';

class CategoryRepository extends Repository
{

    public function create($entity)
    {
        if($entity === null) {
            return null;
        }
        $connection = null;
        $result = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return null;
            }
            $stmt = $connection->prepare("INSERT INTO categories(value) VALUES (?)");

            $value = trim($entity->getValue());
            $stmt->bind_param('s', $value);

            if ($stmt->execute() === true) {
                $result = new \models\Category($connection->insert_id, $entity->getValue());
            }

        } finally {
            $connection?->close();
        }

        return $result;
    }

    public function select(string $searchTxt = null)
    {
        $connection = null;

        $values = [];

        try {
            $connection = $this->db->connect();
            $query = "SELECT * FROM categories";

            if (!empty($searchTxt)) {
                $searchTxt = trim($searchTxt);
                $query .= " WHERE value LIKE ?";
            }
            $stmt = $connection->prepare($query);

            if(!empty($searchTxt)) {
                $value = "%{$searchTxt}%";
                $stmt->bind_param('s', $value);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $values[] = new models\Category($row[0], $row[1]);
            }

        } finally {
            $connection?->close();
        }

        return $values;
    }

    public function update($entity)
    {
        if($entity === null) {
            return;
        }

        $connection = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return false;
            }
            $stmt = $connection->prepare("UPDATE categories SET value=? WHERE id=?");

            $id = $entity->getId();
            $value = $entity->getValue();
            $stmt->bind_param("si", $value, $id);

            $stmt->execute();
        } finally {
            $connection?->close();
        }

        return $entity;
    }

    public function delete($id)
    {
        if($id === null) {
            return;
        }

        $connection = null;

        try {
            $connection = $this->db->connect();
            if($connection->connect_error) {
                return false;
            }
            $stmt = $connection->prepare("DELETE FROM categories WHERE id=?");
            $stmt->bind_param("i", $id);
            $res = $stmt->execute();
        } finally {
            $connection->close();
        }

        return $res;
    }
}