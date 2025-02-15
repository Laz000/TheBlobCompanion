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

// Leggi i valori attuali
$counters = readCounters();

// Gestione dei pulsanti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['decrement_ah1'])) {
        $counters['counter_ah1']--;
    } elseif (isset($_POST['increment_ah2'])) {
        $counters['counter_ah2']++;
    } elseif (isset($_POST['decrement_ah3'])) {
        $counters['counter_ah3']--;
    } elseif (isset($_POST['increment_ah1'])) {
        $counters['counter_ah1']++;
    } elseif (isset($_POST['decrement_ah2'])) {
        $counters['counter_ah2']--;
    } elseif (isset($_POST['increment_ah3'])) {
        $counters['counter_ah3']++;
    }
    
    // Scrivi i nuovi valori nel file JSON
    writeCounters($counters);
}

?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Counter AH</title>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-image: url("images/image1.jpg");
                background-size: cover;
                background-position: center;
                color: white;
                text-align: center;
            }
            .container {
                margin-top: 0px;
                background: rgba(0, 0, 0, 0.7);
                padding: 20px;
                border-radius: 10px;
            }

            .btn-size{
                margin-top:5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Arkham Horror LCG</h1>

            <h2>Vita residua - [<?= $counters['counter_ah1'] ?>]</h2>

            <form method="post">
                <button
                    type="submit"
                    name="increment_ah1"
                    class="btn btn-danger btn-lg btn-block btn-size"> + </button>
            </form>

            <form method="post">
                <button
                    type="submit"
                    name="decrement_ah1"
                    class="btn btn-danger btn-lg btn-block btn-size"> - </button>
            </form>
            <br/>
            <h2>Indizi residui - [<?= $counters['counter_ah2'] ?>]</h2>

            <form method="post">
                <button
                    type="submit"
                    name="increment_ah2"
                    class="btn btn-warning btn-lg btn-block btn-size"> + </button>
            </form>
            <form method="post">
                <button
                    type="submit"
                    name="decrement_ah2"
                    class="btn btn-warning btn-lg btn-block btn-size"> - </button>
            </form>
            <br/>
            <h2>Contromisure residue - [<?= $counters['counter_ah3'] ?>]</h2>
            <form method="post">
                <button
                    type="submit"
                    name="increment_ah3"
                    class="btn btn-success btn-lg btn-block btn-size"> + </button>
            </form>
            <form method="post">
                <button
                    type="submit"
                    name="decrement_ah3"
                    class="btn btn-success btn-lg btn-block btn-size"> - </button>
            </form>
        </div>
    </body>
</html>