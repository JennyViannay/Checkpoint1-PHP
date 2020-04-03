<?php



$dsn = "mysql:host=localhost;dbname=checkpoint1";
$user = "root";
$pwd = "Jimbeck2403*";

$pdo = new PDO($dsn, $user, $pwd);

if ($pdo===false){
    echo "Connection error";
} else {
    $request = "SELECT * FROM bribe";
}



<form action="" method="post">
    <div>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="user_name">
    </div>
    <div>
        <label for="payment">payment :</label>
        <input type="number" id="payment" name="user_payment">
    </div>
    <div class="button">
        <button type="submit">Envoyer le message</button>
    </div>
</form>

