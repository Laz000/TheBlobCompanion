<?php
header('Content-Type: application/json');

// Funzione per leggere i valori dal file JSON
function readCounters() {
    $data = file_get_contents('counters.json');
    return json_decode($data, true);
}

// Leggi i valori attuali
$counters = readCounters();

// Restituisci i valori come JSON
echo json_encode($counters);
?>