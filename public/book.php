<?php
require_once 'connec.php';
$pdo = new PDO(DSN,USER,PASS);
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
            <?php
            if($_POST){
                $name = trim($_POST['name']);
                $payment = trim($_POST['payment']);
                $query = "INSERT INTO bride (name, payment) VALUES (':nom', ':pay')";
                $statement = $pdo->prepare($query);
                $statement->bindValue(':nom', $name, PDO::PARAM_STR);
                $statement->bindValue(':pay', $payment, PDO::PARAM_INT);
                $statement->execute();
                }
                ?>
                <form  action=""  method="POST">
                    <div>
                        <label  for="nom">name :</label>
                        <input  type="text"  id="nom"  name="name" required >
                    </div>
                    <div>
                        <label  for="pay">payment :</label>
                        <input  type="text"  id="pay"  name="payment" required>
                    </div>
                    <button>submit</button>
                </form>
            </div>
            <div class="page rightpage">
            <?php

            $query = "SELECT * FROM bride ORDER BY name ASC";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $NbData = $statement->rowCount();
            $brides = $statement->fetchALL();
            $total = 0;
            foreach ($brides as $bride){
                $total += $bride['payment'];
            }
            foreach($brides as $bride)
            {
            ?>
            <table>
            <thead>
            <tr>
                <td><?php echo $bride['id']; ?></td>
                <td><?php echo $bride['name']; ?></td>
                <td><?php echo $bride['payment']; ?></td>
            </tr>
            </thead>
            <?php
              } 
            ?>
            <tbody>
                <tr>
                    <td> TOTAL : <?php echo $total?></td>
                </tr>
                </tbody>
            </table>
            </tbody>
            </table>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
