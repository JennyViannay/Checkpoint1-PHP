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

<?php include 'header.php';
require_once 'connec.php';
$pdo = new PDO(DSN, USER, PASS);
if($pdo===false){
    echo 'connection error';
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

                <?php 
                $sql = "INSERT INTO bribe (name, payment) VALUES (:name, :payment)";

                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $error = [];
                    if(empty($_POST['name'])){
                        $error['name'] = "Name is missing";
                    }if(empty($_POST['payment']) || $_POST['payment']<0){
                        $error['payment'] = "Payment is missing or < 0";
                    }if(!empty($_POST['name']) && !empty($_POST['payment'] && $_POST['payment']>0)){
                        
                        $prepared = $pdo->prepare($sql);

                        $prepared->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
                        $prepared->bindValue(':payment', $_POST['payment'], PDO::PARAM_STR);

                        $prepared->execute();
                        Header('Location: http://localhost:8000/index.php');
                    }
                }
                
                ?>

                <form method="post">
                    <label for="name">Enter Name :</label>
                    <code style="color: red"><?php if(isset($error['name'])) echo $error['name'];?></code>
                    <input type="text" id="name" name="name">
                    <label for="payment">Payment :</label>
                    <code style="color: red"><?php if(isset($error['payment'])) echo $error['payment'];?></code>
                    <input type="text" id="payment" name="payment">
                    <br>
                    <button>Pay !</button>
                </form>
            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->

                <?php

                $sql = "SELECT * FROM bribe ORDER BY name";
                $results = $pdo->query($sql);
                $bribes = $results->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <thead>
                    <tr>
                        <th>NAME</th>
                        <th>PAYMENT</th>
                    </tr>
                    </thead>
                    <tbody>
                  <?php
                    foreach($bribes as $bribe){
                        ?>
                    <tr>
                        <td><?= $bribe['name'];?></td>
                        <td><?= $bribe['payment'];?></td>
                    </tr>
                    <?php } ?>
                    <tfoot>
                        <?php
                        
                        $sql = "SELECT SUM(payment) AS total FROM bribe";
                        $result = $pdo->query($sql);
                        $result = $result->fetch();
                        $total = $result['total']
                        ?>
                        <td></td>
                        <td><?= "Total : ". $total;?></td>
                    </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
