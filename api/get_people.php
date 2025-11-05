<?php

// api/get_people.php
// This script provides the server-side processing for the DataTables on the people list page.

header('Content-Type: application/json');

require_once __DIR__ . '/../src/bootstrap.php';

/**
 * A basic Server-Side Processing (SSP) class to handle DataTables requests.
 * In a production environment, you might consider a more robust, third-party library.
 */
class PeopleSSP {
    /**
     * Create the data output array for a DataTables JSON response.
     *
     * @param PDO $db The database connection.
     * @param array $request The DataTables request parameters.
     * @param string $table The database table to query.
     * @param string $primaryKey The primary key of the table.
     * @param array $columns The column configuration.
     * @return array The DataTables JSON response array.
     */
    static function simple(PDO $db, array $request, string $table, string $primaryKey, array $columns): array
    {
        $bindings = [];
        $whereClauses = [];

        // Base query
        $sql = "FROM {$table} p";

        // --- JOINS (for future use with leagues/teams) ---
        // $sql .= " LEFT JOIN league_rosters lr ON p.id = lr.person_id";
        // $sql .= " LEFT JOIN leagues l ON lr.league_id = l.id";

        // Always filter out soft-deleted records.
        $whereClauses[] = "p.deleted_at IS NULL";

        // --- SIMPLE SEARCH ---
        if (isset($request['search']) && $request['search']['value'] != '') {
            $searchValue = '%' . $request['search']['value'] . '%';
            
            $searchableColumns = array_filter($columns, function($c) use ($request) {
                // Find the column index from the request's column array
                $colIndex = array_search($c['dt'], array_column($request['columns'], 'data'));
                // Ensure the column exists in the request and is marked as searchable
                return $colIndex !== false && $request['columns'][$colIndex]['searchable'] == 'true';
            });

            if (count($searchableColumns) > 0) {
                $searchClauses = [];
                foreach ($searchableColumns as $column) {
                    // Use the 'db' key for the query
                    $searchClauses[] = $column['db'] . " LIKE ?";
                    $bindings[] = $searchValue;
                }
                $whereClauses[] = "(" . implode(" OR ", $searchClauses) . ")";
            }
        }
        
        // --- ADVANCED SEARCH (SearchBuilder) ---
        // A full implementation requires a recursive parser for the criteria object.
        // This is a placeholder for where that logic would be built.

        // --- BUILD WHERE CLAUSE ---
        $whereSql = count($whereClauses) > 0 ? ' WHERE ' . implode(' AND ', $whereClauses) : '';

        // --- RECORD COUNTS ---
        // Total records
        $resTotal = $db->query("SELECT COUNT({$primaryKey}) {$sql}");
        $recordsTotal = $resTotal->fetchColumn();

        // Filtered records
        $stmtFiltered = $db->prepare("SELECT COUNT({$primaryKey}) {$sql} {$whereSql}");
        $stmtFiltered->execute($bindings);
        $recordsFiltered = $stmtFiltered->fetchColumn();

        // --- ORDERING ---
        $orderSql = '';
        if (isset($request['order']) && count($request['order'])) {
            $orderBy = [];
            foreach ($request['order'] as $order) {
                $colIndex = intval($order['column']);
                if ($request['columns'][$colIndex]['orderable'] == 'true') {
                    $colData = $request['columns'][$colIndex]['data'];
                    
                    // Find the corresponding DB column from our configuration
                    $colDb = '';
                    foreach($columns as $c) {
                        if ($c['dt'] === $colData) {
                            $colDb = $c['db'];
                            break;
                        }
                    }
                    
                    if ($colDb) {
                        $dir = $order['dir'] === 'asc' ? 'ASC' : 'DESC';
                        $orderBy[] = $colDb . ' ' . $dir;
                    }
                }
            }
            if (count($orderBy) > 0) {
                $orderSql = ' ORDER BY ' . implode(', ', $orderBy);
            }
        }
        
        // --- PAGINATION ---
        $limitSql = '';
        if (isset($request['start']) && $request['length'] != -1) {
            $limitSql = " LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }
        
        // --- FETCH DATA ---
        $columnList = array_map(
            fn($c) => isset($c['alias']) ? $c['db'] . ' AS ' . $c['alias'] : $c['db'], 
            $columns
        );
        
        $stmtData = $db->prepare("SELECT " . implode(", ", $columnList) . " {$sql} {$whereSql} {$orderSql} {$limitSql}");
        $stmtData->execute($bindings);
        $data = $stmtData->fetchAll(PDO::FETCH_ASSOC);

        // --- FORMAT AND RETURN ---
        return [
            "draw"            => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => $data
        ];
    }
}

// --- DataTable Configuration ---
$tableName = 'people';
$primaryKey = 'id';

// Map DataTables columns to database columns.
// 'dt' is the DataTables alias, 'db' is the actual database column.
$columns = [
    ['db' => 'p.id', 'dt' => 'id'],
    ['db' => 'p.first_name', 'dt' => 'first_name'],
    ['db' => 'p.last_name', 'dt' => 'last_name'],
    ['db' => 'p.email', 'dt' => 'email'],
    ['db' => 'p.dob', 'dt' => 'dob'],
    ['db' => 'p.address_1', 'dt' => 'address_1'],
    ['db' => 'p.city', 'dt' => 'city'],
    ['db' => 'p.state', 'dt' => 'state'],
    ['db' => 'p.status', 'dt' => 'status'],
    ['db' => 'p.created_at', 'dt' => 'created_at']
    // The 'Actions' column is generated in the frontend and doesn't have a 'db' mapping here.
];

// --- Execution ---
// The global $db connection comes from the included bootstrap.php file.
echo json_encode(
    PeopleSSP::simple($db, $_POST, $tableName, $primaryKey, $columns)
);
