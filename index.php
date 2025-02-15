<?php
session_start();


// Funzione per leggere i valori dal file JSON
function readCounters() {
    $data = file_get_contents('counters.json');
    return json_decode($data, true);
}

// Leggi i valori attuali
$counters = readCounters();



?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CasaLeCG di Reno - The Blob Companion</title>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-image: url("images/image1.jpg");
                background-size: cover;
                /* Copre l'intera area */
                background-position: center;
                /* Centra l'immagine */
                background-repeat: no-repeat;
                /* Non ripete l'immagine */
                opacity: 1;
                /* Riduce l'intensità dell'immagine di sfondo */
            }

            .overlay {
                position: fixed;
                /* Fissa l'overlay */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.5);
                /* Colore bianco con opacità */
                z-index: 0;
                /* Assicura che l'overlay sia sotto il contenuto */
            }

            .container {
                position: relative;
                /* Necessario per il posizionamento del contenuto */
                z-index: 1;
                /* Assicura che il contenuto sia sopra lo sfondo */
            }

            .counter {
                font-size: 0.6rem;
                /* Dimensione del font per il contatore */
                text-align: center;
                /* Centra il testo */
                margin: 80px 0;
                /* Spazio sopra e sotto il contatore */
                width: 100%;
                /* Occupa tutta la larghezza */
            }

            .image-column {
                height: 60vh;
                /* Altezza fissa per le colonne */
                padding: 20px;
                /* Padding per il contenuto */
            }

            .list-unstyled li {
                color: #000;
                /* Colore del testo */
                font-weight: bold;
                /* Rende il testo più spesso */
            }
            .popup {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1000;
                background-color: rgba(255, 255, 255, 0.9);
                border: 1px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                width: 80%;
                /* Aumenta la larghezza */
                height: 80%;
                /* Aumenta l'altezza */
            }

            .popup-content {
                position: relative;
                padding: 20px;
                text-align: center;
                width: 100%;
                /* Assicura che il contenuto occupi tutta la larghezza */
                height: 100%;
                /* Assicura che il contenuto occupi tutta l'altezza */
            }

            .popup-content img {
                max-width: 100%;
                /* Assicura che l'immagine non superi la larghezza della popup */
                max-height: 100%;
                /* Assicura che l'immagine non superi l'altezza della popup */
            }

            .counter-text {
                font-size: 3rem;
                /* Rende il testo più grande */
                font-weight: bold;
                color: black;
                -webkit-text-stroke: 2px white;
                /* Bordo bianco */
                text-shadow: 2px 2px 4px white;
            }

            .close {
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
                font-size: 20px;
            }

            .row-title {
                margin-top: 20px;
            }

            .row-header {
                margin-top: 80px;
            }

            .qr-code{
                margin-top: 80px;
            }
        </style>
    </head>
    <body>
        <div class="overlay"></div>
        <!-- Overlay per l'opacità -->

        <div class="container">
            <div class="row row-title">
                <!--Title -->
                <div class="col-12 d-flex justify-content-center">
                    <span class="counter-text">La Melma che Divorò ogni Cosa - Companion</span>
                </div>
            </div>
            <div class="counter">
                <div id="countdown" class="h4"></div>
            </div>

            <div class="row row-header">
                <!-- Life -->
                <div class="col-4 d-flex justify-content-center">
                    <span class="counter-text">Vita</span>
                </div>
                <div class="col-4 d-flex justify-content-center">
                    <span class="counter-text">Indizi residui</span>
                </div>
                <!-- Countermeasures -->
                <div class="col-4 d-flex justify-content-center">
                    <span class="counter-text">Contromisure</span>
                </div>
            </div>
            <div class="row row-stats">
                <!-- Life -->
                <div class="col-4 d-flex justify-content-center">
                    <span id="counter_ah1" class="counter-text"><?= $counters['counter_ah1'] ?></span>
                </div>
                <div class="col-4 d-flex justify-content-center">
                    <span id="counter_ah2" class="counter-text"><?= $counters['counter_ah2'] ?></span>
                </div>
                <!-- Countermeasures -->
                <div class="col-4 d-flex justify-content-center">
                    <span id="counter_ah3" class="counter-text"><?= $counters['counter_ah3'] ?></span>
                </div>
            </div>
            <div class="row">
                <!-- QR Code -->
                <div class="col-12 d-flex justify-content-center qr-code">
                    <img src="images/ah.svg" width="200px" height="200px"/>
                </div>
            </div>
            <div class="counter">
                <div id="countdown" class="h2"></div>
            </div>
        </div>

        <script>
            let timer = 11400;
            const countdownElement = document.getElementById('countdown');

            function updateCountdown() {
                const hours = Math.floor(timer / 3600);
                const minutes = Math.floor((timer % 3600) / 60);
                const seconds = timer % 60;
                countdownElement.innerHTML = ''; // Pulisci il contenuto precedente

                // Aggiungi le immagini per le ore
                const hourImages = String(hours)
                    .padStart(2, '0')
                    .split('')
                    .map(num => {
                        return `<img src="images/${num}.png" alt="${num}" style="height: 200px;">`;
                    });
                hourImages.forEach(img => countdownElement.innerHTML += img);

                // Add colon
                countdownElement.innerHTML += '<img src="images/colon.png" alt=":">';

                // Aggiungi le immagini per i minuti
                const minuteImages = String(minutes)
                    .padStart(2, '0')
                    .split('')
                    .map(num => {
                        return `<img src="images/${num}.png" alt="${num}" style="height: 200px;">`;
                    });
                minuteImages.forEach(img => countdownElement.innerHTML += img);

                // Add colon
                countdownElement.innerHTML += '<img src="images/colon.png" alt=":">';

                // Aggiungi le immagini per i secondi
                const secondImages = String(seconds)
                    .padStart(2, '0')
                    .split('')
                    .map(num => {
                        return `<img src="images/${num}.png" alt="${num}" style="height: 200px;">`;
                    });
                secondImages.forEach(img => countdownElement.innerHTML += img);

                timer--;

                if (timer < 0) {
                    clearInterval(countdownInterval);
                    document
                        .body
                        .classList
                        .add('flash'); // Aggiungi la classe flash solo se il timer scade
                }
            }

            // Avvia il countdown solo se il timer è maggiore di zero
            if (timer > 0) {
                const countdownInterval = setInterval(updateCountdown, 1000);
            }

            function updateValues() {
                fetch('get_values.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Controlla se ci sono errori nei dati
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }
                        document
                            .getElementById('counter_ah1')
                            .innerText = data.counter_ah1 !== undefined
                                ? data.counter_ah1
                                : 0;
                        document
                            .getElementById('counter_ah2')
                            .innerText = data.counter_ah2 !== undefined
                                ? data.counter_ah2
                                : 0;
                        document
                            .getElementById('counter_ah3')
                            .innerText = data.counter_ah3 !== undefined
                                ? data.counter_ah3
                                : 0;
                    })
                    .catch(error => console.error('Error fetching values:', error));
            }

            // Aggiorna i valori ogni 5 secondi
            setInterval(updateValues, 5000);

            // Genera i QR code
            const qrAH = new QRious({
                element: document.getElementById('qr_ah'), value: 'https://teambydesign.it/TheBlobCompanion/ah_counters.php' // URI per Arkham Horror
            });
        </script>
    </body>
</html>