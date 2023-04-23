<?php

namespace objects;

class Employee
{
    private int $id;
    private Person $person;
    private Role $role;

    public function __construct($id, Person $person, Role $role)
    {
        $this->setId($id);
        $this->setPerson($person);
        $this->setRole($role);
    }

    public function getId(): int {
        return $this->id;
    }
    public function getPerson(): Person {
        return $this->person;
    }

    public function getRole(): Role {
        return $this->role;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPerson(Person $person): void {
        if($person === null) {
            return;
        }

        $this->person = $person;
    }

    public function setRole(Role $role): void {
        if($role === null) {
            return;
        }

        $this->role = $role;
    }

    public function __toString(): string {
        $name = $this->person?->getName() ?? "";
        $role = $this->role?->getValue() ?? "";
        return "$name ($role)";
    }

    public function equals($employee) : bool {
        if($employee === null) {
            return false;
        }

        if(!($employee instanceof Employee)) {
            return false;
        }

        return $this->id === $employee->id && $this->person?->getId() === $employee->getPerson()?->getId() && $this->role?->getId() === $employee->getRole()?->getId();
    }
}