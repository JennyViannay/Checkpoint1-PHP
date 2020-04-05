<?php
require 'connec.php';

$pdo = new PDO('mysql:host=localhost;dbname=checkpoint1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
if($pdo === false){
    echo 'Connection Error :' .$pdo->error_log();
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $request = "SELECT * FROM bribe WHERE id=" . $id;
    $sendRequest = $pdo->query($request);
    if ($sendRequest === false) {
        $pdo->errorInfo();
    }
    $bribe = $sendRequest->fetchObject();
}
if(isset($_GET['name']) && !empty($_GET['name'])) {
    $name = $_GET['name'];
    $request = "SELECT * FROM bribe WHERE name=" . $name;
    $sendRequest = $pdo->query($request);
    if ($sendRequest === false) {
        $pdo->errorInfo();
    }
    $bribe = $sendRequest->fetchObject();

    if (isset($_GET['payment']) && !empty($_GET['payment'])) {
        $payment = $_GET['payment'];
        $request = "SELECT * FROM bribe WHERE payment=" . $payment;
        $sendRequest = $pdo->query($request);
        if ($sendRequest === false) {
            $pdo->errorInfo();
        }
        $bribe = $sendRequest->fetchObject();
    }
}

if(isset($_POST) && !empty($_POST)){
    $id = $_GET['id'];
    if(!empty($_POST['name']) && !empty($_POST['payment'])) {
        try{
            $editBribe = $pdo->prepare("UPDATE bribe SET name=:name, payment=:payment WHERE id=:id");
            $editBribe->execute([
                'name' => $_POST['name'],
                'payment' => $_POST['payment'],
                'id' => $id
            ]);
            header('Location: http://localhost:63342/new_Checkpoint/Checkpoint1-PHP/public/book.php');
        } catch (PDOException $e){
            echo $error = $e->getMessage();
        }
    } else {
        $error = 'I WANT THEIR NAME 🔫  ';
    }
}