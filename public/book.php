<?php
require 'connec.php';
$pdo = new PDO('mysql:host=localhost;dbname=checkpoint1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
if($pdo === false){
    echo "Connection error :" . $pdo->error_log();
} else {
    $query = $pdo->query('SELECT * FROM bribe');
    $bribe = $query->fetchAll(PDO::FETCH_ASSOC);
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

if (isset($_POST)) {
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
       // } else {
        //echo 'I WANT THEIR NAME 🔫';
    }

}
$sum = 0;
foreach($bribe as $value) {
    for($value=1; $value<=5; $value++)
    {
    $sum +=$value;
    }
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
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                <!-- TODO : Form -->
                <?php if (isset($error)) {
                        echo $error;
                        } ?>
                <h3>⚜️Thug life ⚜. Those bitches owe me 💸.️</h3>
                <?php foreach ($bribe as $bribeInfo) { ?>
                    <div>
                        <ul class="list">
                            <li class="theyOweMe_list">Their MOTHAF*** Name : <?php echo $bribeInfo['name'] ?></li>
                            <li class="theyOweMe_list">WHAT they OWE ME :<?php echo $bribeInfo['payment'] ?></li>
                        </ul>
                    </div>
                <?php }?>

                <form class="formThug" method="POST">
                    <label for="Name"></label>
                    <input class="inputThug" type="text" name="name" id="name" placeholder="Their MOTHAF*** name">
                    <span><?php echo $error ;?></span>
                    <label for="Payment"></label>
                    <input class="inputThug" type="text" name="payment" id="payment" placeholder="What they OWE ME">
                    <button class="buttThug" type="submit">Submit</button>
                </form>
            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
                <h3>⚜️Thug life ⚜. Those bitches owe me 💸.️</h3>

                    <table style="width:100%">
                        <thead>
                            <tr>
                                <th class="theyOweMe">Their MOTHAF*** Name</th>
                                <th class="theyOweMe">WHAT they OWE ME</th>
                            </tr>
                            </thead>
                        <?php foreach ($bribe as $bribeInfo) { ?>
                        <tbody>
                            <tr>
                                <td class="theyOweMe"><?php echo $bribeInfo['name'] ?></td>
                                <td class="theyOweMe"><?php echo $bribeInfo['payment'] ?></td>
                            </tr>
                        </tbody>
                        <?php }?>
                        <tfoot>
                            <tr>
                                <td>Sum</td>
                                <td><?php echo $sum; ?></td>
                            </tr>
                        </tfoot>
                    </table>

            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
