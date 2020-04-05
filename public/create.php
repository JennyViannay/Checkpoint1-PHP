<?php
require 'connec.php';

$pdo = new PDO('mysql:host=localhost;dbname=checkpoint1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
if($pdo === false){
    echo 'Connection Error :' .$pdo->error_log();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['payment'])) {
        try {
            $request = $pdo->prepare('INSERT INTO bribe (name, payment) VALUES (:name,:payment)');
            $request->execute([
                'name' => $_POST['name'],
                'payment' => $_POST['payment']
            ]);
            header('Location: http://http://localhost:63342/new_Checkpoint/Checkpoint1-PHP/public/book.php');
        } catch (PDOException $e) {
            echo $error = $e->getMessage();
        }
    } else {
        $error = 'I WANT THEIR NAME 🔫  ';
    }
}

