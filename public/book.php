<?php 

$dsn="mysql:host=localhost;dbname=checkpoint1";
$user="root";
$password="root";

$pdo= new PDO($dsn,$user,$password);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>

<?php include 'header.php'; ?>

<?php 
$pdo= new PDO($dsn,$user,$password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
if (isset($_POST)){
    var_dump($_POST);
    if(!empty($_POST['name']) && !empty($_POST['payment'])){
        $insertFriends = $pdo->prepare("INSERT INTO bribe(name, payment) VALUES (:name, :payment)");
        $insertFriends->execute([
            'name'=> $_POST['name'],
            'payment'=> $_POST['payment'],
            ]);
        
    }else{
        echo 'veuillez remplir tous les champs';
        
    }
}


?>
<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                Add a bribe
                <!-- TODO : Form -->
                <form method="POST">
<label for="name"></label>
<input type="text" name="name" id="name" placeholder="Name">
<br>
<label for="payment"></label>
<input type="text" name="payment" id="payment" placeholder="Payment">
<br>
<button type="submit"> Create</button>
</form>
            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
<?php
if ($pdo === false){
    echo "error connexion".$pdo->error_log();
}else{
    $query = "SELECT * FROM bribe";
    $statement = $pdo->query($query);   
    $bribe = $statement->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($brib);
    foreach($bribe as $brib){
        //var_dump($brib);
?>
                <div>
                    <p> <?php echo $brib['name'];?></p>
                    <p> <?php echo $brib['payment'];?></p>
                </div>
<?php
    }
}

?>
<!-- Calcul total
                <div>
                    <//?php 
                    //$calcul = "SELECT SUM(payment) FROM bribe";
                    //$appel = mysql_query($calcul);
                    //$donnees = $appel->fetchAll(PDO::FETCH_ASSOC);
                    //$total = mysql_fetch_row($donnes);
                    //echo 'total: '. $total;
                    
                    
                    ?>
                </div>
-->
                
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
