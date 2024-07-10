<?php
// Nama file CSV
define('CSV_FILE', 'commands.csv');

// Fungsi untuk mendapatkan data dari file CSV
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

// Fungsi untuk menambah data ke file CSV dengan menimpa data sebelumnya
function addData($command) {
    $newData = ['command' => $command];
    if (($handle = fopen(CSV_FILE, "w")) !== FALSE) {
        fputcsv($handle, $newData);
        fclose($handle);
    }
    return $newData;
}
?>