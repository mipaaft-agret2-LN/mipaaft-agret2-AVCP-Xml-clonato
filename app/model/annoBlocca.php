<?php
$anno = (int) $_GET['anno'];
$da = 'da' . $anno;

$avanzato = 'n';
$messOk = false;
// Controllo se era già stato eseguito un avanzamento sull'anno da bloccare
$queryVer = "SELECT count(id) AS quanti FROM avcp_lotto WHERE flag = '" . $da . "'";
$resVer = $db->query($queryVer);
if ($db->affected_rows == 1) {
    $numAv = $resVer->fetch_assoc();
    if ($numAv['quanti'] > 0) {
        $avanzato = 's';
    }
}

// Blocco l'anno corrente inserendo il corretto status di avanzamento
if ($_SESSION['user'] == 'admin' && !array_key_exists($anno, $bloccati)) {
    $queryBlocco = "INSERT INTO bloccati (anno, avanzato) VALUES ('" . $anno . "', '" . $avanzato . "')";
    $resBlocco = $db->query($queryBlocco);
    if ($db->affected_rows == 1) {
        $messOk = true;
        $message = '<strong>Tutto ok:</strong> Anno ' . $anno . ' bloccato</h2>';
    } else {
        $message = '<strong>Errore:</strong> Blocco non permesso!';
    }
}
