<?php
header('Access-Control-Allow-Origin: *'); // Mengizinkan semua origin, bisa juga spesifik misalnya 'http://localhost:8100'
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

define('CSV_FILE', 'commands.csv');

function getData() {
    $data = [];
    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = ['command' => $row[0]];
        }
        fclose($handle);
    }
    return $data;
}

function addData($command) {
    $newData = ['command' => $command];
    if (($handle = fopen(CSV_FILE, "w")) !== FALSE) {
        fputcsv($handle, $newData);
        fclose($handle);
    }
    return $newData;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = getData();
    echo json_encode(['status' => 'success', 'data' => $data]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['command'])) {
        $newData = addData($input['command']);
        echo json_encode(['status' => 'success', 'data' => $newData]);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
?>
