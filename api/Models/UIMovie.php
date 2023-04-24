<?php

namespace Models;
require_once __DIR__ . '\..\..\db\Models\Movie.php';
class UIMovie
{
    public static function getMovie($movie) : array {
        if($movie === null) {
            return [];
        }
        $staff_models = $movie->getStaff();
        $staff = self::getStaff($staff_models);

        return [
            'id' => $movie->getId(),
            'title' => $movie->getOriginalTitle(),
            'category' => [
                'id' => $movie->getCategory()->getId(),
                'value' => $movie->getCategory()->getValue(),
            ],
            'description' => $movie->getDescription(),
            'year' => $movie->getYear(),
            'duration' => $movie->getDuration(),
            'rate' => $movie->getRate(),
            'votes' => $movie->getVotes(),
            'staff' => $staff
        ];
    }
    private static function getStaff(array $staff) : array {
        if($staff === null || !is_array($staff) || count($staff) === 0) {
            return [];
        }

        $models = [];
        foreach ($staff as $employee) {
            $person = $employee->getPerson();
            $role = $employee->getRole();

            if($person === null || $role === null) {
                continue;
            }

            $models[] = [
                'person' => [
                    'id' => $person->getId(),
                    'name' => $person->getName()
                ],
                'role' => [
                    'id' => $role->getId(),
                    'value' => $role->getValue()
                ]
            ];
        }

        return $models;
    }
}