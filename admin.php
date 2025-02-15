<?php
session_start();

// Funzione per leggere i valori dal file JSON
function readCounters() {
    $data = file_get_contents('counters.json');
    return json_decode($data, true);
}

// Funzione per scrivere i valori nel file JSON
function writeCounters($counters) {
    file_put_contents('counters.json', json_encode($counters, JSON_PRETTY_PRINT));
}

// Inizializza i counter e il timer se non sono già impostati
$counters = readCounters();
if ($counters === null) {
    // Se non riesci a leggere i valori, inizializza i valori di default
    $counters = [
        "counter_ah1" => 0,
        "counter_ah2" => 0,
        "counter_ah3" => 0,
        "counter_lotr1" => 0,
        "counter_mc1" => 0,
        "timer" => 11400
    ];
}

// Gestisci l'invio del modulo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_values'])) {
        $counters['counter_ah1'] = intval($_POST['counter_ah1']);
        $counters['counter_ah2'] = intval($_POST['counter_ah2']);
        $counters['counter_ah3'] = intval($_POST['counter_ah3']);
        $counters['counter_lotr1'] = intval($_POST['counter_lotr1']);
        $counters['counter_mc1'] = intval($_POST['counter_mc1']);
        $counters['timer'] = intval($_POST['timer']);
        
        // Scrivi i nuovi valori nel file JSON
        writeCounters($counters);
    } elseif (isset($_POST['start_timer'])) {
        // Avvia il timer (imposta il valore a 180 minuti se non è già stato impostato)
        $counters['timer'] = 11400; // Puoi cambiare questo valore se desideri un timer diverso
        writeCounters($counters);
    }
 
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Impostazioni Admin</h1>
        <form method="post">
            <div class="form-group">
                <label for="counter_ah1">Valore Counter AH1:</label>
                <input type="number" id="counter_ah1" name="counter_ah1" class="form-control" value="<?= $counters['counter_ah1'] ?>" required>
            </div>
            <div class="form-group">
                <label for="counter_ah2">Valore Counter AH2:</label>
                <input type="number" id="counter_ah2" name="counter_ah2" class="form-control" value="<?= $counters['counter_ah2'] ?>" required>
            </div>
            <div class="form-group">
                <label for="counter_ah3">Valore Counter AH3:</label>
                <input type="number" id="counter_ah3" name="counter_ah3" class="form-control" value="<?= $counters['counter_ah3'] ?>" required>
            </div>
            <button type="submit" name="set_values" class="btn btn-primary">Imposta Valori</button>
            <button type="submit" name="start_timer" class="btn btn-success">Avvia Timer</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Torna alla Home</a>
    </div>
</body>
</html>