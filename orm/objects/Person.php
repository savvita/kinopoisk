<?php

namespace objects;

class Person
{
    private int $id;
    private string $name;

    public function __construct($id, $name)
    {
        $this->setId($id);
        $this->setName($name);
    }

    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        if(empty($name) || strlen($name) > 100) {
            return;
        }

        $this->name = $name;
    }

    public function __toString(): string {
        return $this->name;
    }

    public function equals($person) : bool {
        if($person === null) {
            return false;
        }

        if(!($person instanceof Person)) {
            return false;
        }

        return $this->id === $person->id && $this->name === $person->getName();
    }
}