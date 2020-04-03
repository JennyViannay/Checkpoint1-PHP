<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

$query = $pdo->prepare("SELECT * FROM bribe");
$querySelect = $query->execute();
$bribe = $query->fetchAll();

if ((isset($_POST['send'])) && !empty($_POST['name']) && !empty($_POST['payment']) && $_POST['payment']>0){

    $name = trim($_POST['name']);
    $payment = trim($_POST['payment']);

    $query = $pdo->prepare("INSERT INTO bribe (name, payment) values ('$name', '$payment')");

    $query->bindValue($name, $_POST['name'], PDO::PARAM_STR);
    $query->bindValue($payment, $_POST['payment'], PDO::PARAM_INT);

    $queryInsert = $query->execute();
}

if ($queryInsert = true && !empty($_POST['name']) && !empty($_POST['payment']) && $_POST['payment'] > 0){
    $delai = 1;
    $url = "http://localhost:8000/book.php";
    header("Refresh: $delai;url=$url");
}else{
    $error['payment'] = "Don't try to fuck me boy/girl, give me some money ! ";
    $error['name'] = "I don't take money from anonymous guys, sorry man/girl..";
}

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

<main class="container">

    <section class="desktop">
        <img class="tumfaischier" src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img class="empty_whisky" src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <img class="jesaisjesaisjeforce" src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>
            <img src="image/whisky.png" class="ptdrcommentjtebrain" alt="a whisky glass" class="whisky"/>
            <div class="page leftpage">
                <h1> Add a bribe </h1>
                <p> <?php
                    if ( isset($_POST['send']) && empty($_POST['payment'])){
                        echo $error['payment'];
                    }
                    if (isset($_POST['send']) && empty($_POST['name'])){
                        echo $error['name'];
                    }
                    ?> </p>
                <form method="post">
                    <label> Name</label>
                    <input type="text" name="name" placeholder="name" >
                    <label> payment</label>
                    <input type="number" name="payment" step="1" placeholder="0">
                    <input type="submit" name="send" value="Pay !">
            </div>
            <div class="page rightpage">
                <?php
                $total = 0;
                foreach ($bribe as $pay) {
                    $total += $pay['payment'];
                }
                ?>
                <?php foreach ($bribe as $bribes) { ?>
                <table>
                    <thead>
                    <tr>
                        <th><?php echo $bribes['name'] ?></th>
                        <th><?php echo $bribes['payment'] ?> </th>
                    </tr>
                    </thead>
                    <?php } ?>
                    <tbody>
                    <tr>
                        <td> TOTAL : <?php echo $total?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <img src="image/inkpen.png" class="jesuisunforceur" alt="an ink pen" class="inkpen"/>
        </div>
        <img src="image/inkpen.png" class="toiaussitufaischier" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
