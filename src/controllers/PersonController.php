<?php

require_once __DIR__ . '/../models/Person.php';

class PersonController {

    public function index() {
        $personModel = new Person();
        $stmt = $personModel->getAll();
        $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pass data to the view
        $data = [
            'persons' => $persons
        ];

        // Load the view
        $this->loadView('persons/index', $data);
    }

    /**
     * A helper function to load views and pass data.
     */
    private function loadView($view, $data = []) {
        extract($data);

        // The header and footer will be included from the main layout file
        // which is handled by the router in public/index.php
        include_once __DIR__ . '/../views/' . $view . '.php';
    }

    // Other CRUD methods (create, store, edit, update, delete) will go here.

}
