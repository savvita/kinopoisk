<?php

namespace controllers;
require_once 'orm/objects/User.php';
class UserRepository extends Repository
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
            $stmt = $connection->prepare("INSERT INTO users(login, password, premium) VALUES (?, ?, ?)");

            $login = trim($entity->getLogin());
            $password = trim($entity->getPassword());
            $premium = $entity->getPremium();
            $stmt->bind_param('ssi', $login, $password, $premium);

            if ($stmt->execute() === true) {
                $result = new \objects\User($connection->insert_id, $entity->getLogin(), $entity->getPassword(), $entity->getPremium());
            }

        } finally {
            $connection?->close();
        }

        return $result;
    }

    public function select(string $searchTxt)
    {
        $connection = null;

        $values = [];

        try {
            $connection = $this->db->connect();
            $query = "SELECT * FROM users";

            if (!empty($searchTxt)) {
                $searchTxt = trim($searchTxt);
                $query .= " WHERE value = ?";
            }
            $stmt = $connection->prepare($query);

            if(!empty($searchTxt)) {
                $stmt->bind_param('s', $searchTxt);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $values[] = new objects\User($row[0], $row[1], $row[2], $row[3]);
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
            $stmt = $connection->prepare("UPDATE users SET login=?, password=?, premium=? WHERE id=?");

            $id = $entity->getId();
            $login = $entity->getLogin();
            $password = $entity->getPassword();
            $premium = $entity->getPremium();
            $stmt->bind_param("ssii", $login, $password, $premium, $id);

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
            $stmt = $connection->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            $res = $stmt->execute();
        } finally {
            $connection->close();
        }

        return $res;
    }
}