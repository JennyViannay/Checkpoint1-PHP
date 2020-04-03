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

<?php include 'header.php';  require_once 'connec.php';
$pdo = new PDO(DSN, USER, PASS);

$query = $pdo->prepare('SELECT * FROM bribe ORDER BY name');
$query->execute();
$bribes = $query->fetchAll();

$querySum = $pdo->prepare('SELECT SUM(payment) FROM bribe');
$querySum->execute();
$somme = $querySum->fetch();

if($_POST) {
    $errors = array();
    if(empty($_POST['name'])) {
    $errors['name'] = "Ce champ est obligatoire";
}
    if(empty($_POST['payment'])||$_POST<0) {
        $errors['payment'] = "Ce champ est obligatoire et doit être suppérieur à 0";
}
    if (!empty($_POST['name']) && !empty($_POST['payment']) && $_POST['payment'] > 0) {
        $name = trim($_POST['name']);
        $payment = trim($_POST['payment']);

        $queryInsert = $pdo->prepare("INSERT INTO bribe (name, payment) VALUES ('$name', '$payment')");

        $queryInsert->bindValue($name, $_POST['name'], PDO::PARAM_STR);
        $queryInsert->bindValue($payment, $_POST['payment'], PDO::PARAM_INT);

        $insertOk = $queryInsert->execute();

        if ($insertOk) {
            $delai = 1;
            $url = 'http://localhost:8000/book.php';
            header("Refresh: $delai;url=$url");
        }
    }
}
?>

<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
               <h1>Add a bribe</h1>
                <!-- TODO : Form -->
                <form method ='POST'>
                    <div>
                        <?php if(isset($errors['name'])) echo $errors['name']; ?>
                        <?php if(isset($erreur['payment'])) echo $errors['payment']; ?>
                        <label for="name">Name :</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <label for="payment">Payment :</label>
                    <input type="text" id="payment" name="payment" required>
                    <div>
                        <button type="submit" name="submit">Pay !</button>
                    </div>

                </form>

            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
              <h1>S</h1>
                <hr>
                <ul>
                    <?php foreach ($bribes as $bribe): ?>
                        <li>
                            <?= $bribe['name']?>  <?= $bribe['payment']."€"?>
                        </li>
                    <?php endforeach;?>
                    <hr>
                <tfoot>
                    <td>Total</td>
                    <?php echo $somme[0]. "€"; ?>
                </tfoot>
                </ul>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>

