<?php

namespace App\Controllers;

use App\Models\Person;
use PDO;

class PersonController {

    public function index() {
        // The autoloader now handles loading the Person model.
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
     * This now uses the ROOT_PATH constant for reliable pathing.
     */
    private function loadView($view, $data = []) {
        extract($data);

        // Construct the full path to the view file
        $viewPath = ROOT_PATH . '/src/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            include_once $viewPath;
        } else {
            // In a real app, you'd want more robust error handling
            echo "<p>Error: View not found at path: " . htmlspecialchars($viewPath) . "</p>";
        }
    }

    // Other CRUD methods (create, store, edit, update, delete) will go here.

}
