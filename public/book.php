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

<?php

    require '../connec.php';
    include 'header.php';

    $pdo = new \PDO(DSN, USER, PASS);
    if($pdo === false){
        echo 'Connection Error :' .$pdo->error_log();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $error = [];
        if(empty($_POST['name'])){
            $error['name'] = "Name required";
        }
        if(empty($_POST['payment'])){
            $error['payment'] = "Payment required";
        }
        if($_POST['payment'] < 0){
            $error['price'] = "The price must not be less than 0";
        }
        if(count($error)==0){
            $queryNewBribe = "INSERT INTO bribe(name,payment) VALUES (:name, :payment)";
            $statementNewBribe = $pdo->prepare($queryNewBribe);
            $statementNewBribe ->execute([
                'name' => $_POST['name'],
                'payment' => $_POST['payment'],
            ]);

            header("Location: index.php");
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

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form">

                    <?php
                        if(isset($error['name'])) echo $error['name']."<br>";
                        if(isset($error['payment'])) echo $error['payment'];
                        if(!isset($error['payment']) && isset($error['price'])) echo $error['price'];
                    ?>
                    <div>
                        <label for="input_name">Name: </label>
                        <input type="text" name="name" id="input_name">
                    </div>
                    <div>
                        <label for="input_payment">Payment</label>
                        <input type="number" name="payment" id="input_payment">
                    </div>
                    <div class="buttom">
                        <input type="submit" value="Save" name="save">
                    </div>
                </form>

            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
                <?php
                    $query = " SELECT * FROM bribe ORDER BY name ASC";
                    $statement = $pdo->query($query);
                    $bribe = $statement->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <table>
                    <tbody>
                        <?php
                            $somme = 0;
                            foreach($bribe as $bribe){ ?>
                        <tr>
                            <td><?php echo $bribe['name']?></td>
                            <td><?php echo $bribe['payment']?></td>
                        </tr>
                        <?php
                            $somme += $bribe['payment'];
                            }
                        ?>
                    </tbody>
                    <tfoot
                        <tr>
                            <th scope="row">Totals</th>
                            <td><?php echo $somme ?></td>
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
