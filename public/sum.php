<?php
$sumRequest = "SELECT SUM(payment) AS total FROM bribe";
try {
    $sendRequest = $pdo->query($sumRequest);
    $sumPayments = $sendRequest->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = $e->getMessage();
}
