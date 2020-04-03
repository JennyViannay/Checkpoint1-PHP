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
                Add a bribe
                <!-- TODO : Form -->

                <?php


                $pdo = new \PDO(DSN, USER, PASS);
                $query = "SELECT * FROM bride";
                $statement = $pdo->query($query);
                $bride = $statement->fetchAll(PDO::FETCH_ASSOC);


                $name = '';
                $payment = '';
                $nameErr ='';
                $paymentErr = '';
                $error = 0;

                function test_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                    if (empty($_POST['name'])) {
                        $nameErr = '* Name required';
                        $error += 1;
                    } else {
                        $name = test_input($_POST['name']);
                        if (!preg_match("/^([\p{L}a-zA-Z ]*)$/ui", $name)  || strlen($name) > 45) {
                            $nameErr = '* Only letters and white spaces';
                            $error += 1;
                        }
                    }

                    if (empty($_POST['payment'])) {
                        $paymentErr = '* payment required';
                        $error += 1;
                    } else {
                        $payment = test_input($_POST['firstname']);
                        if (!preg_match("#^(1|2|3|4|5|6|7|8|9|10)$#", $payment) || strlen($payment) > 45) {
                            $paymentErr = '* Only numbers';
                            $error += 1;
                        }
                    }


                    if ($error === 0) {
                        $query = 'INSERT INTO bride (name, payment) VALUES (:name, :payment)';
                        $statement = $pdo->prepare($query);

                        $statement->bindValue(':name', $name, \PDO::PARAM_STR);
                        $statement->bindValue(':payment', $payment, \PDO::PARAM_STR);

                        $statement->execute();
                    }
                }
                ?>


                <form  action="index.php"  method="post">
                    <div>
                        <label  for="name">Name :</label>
                        <input  type="text"  id="name"  name="name">
                        <span class="error"><?php echo $nameErr;?></span>
                        <br><br>
                    </div>
                    <div>
                        <label  for="payment">Payment :</label>
                        <input  type="text"  id="payment"  name="payment">
                        <span class="error"><?php echo $paymentErr;?></span>
                        <br><br>
                    </div>
                    <div  class="button">
                        <button  type="submit">Add</button>
                    </div>
                </form>



            </div>

            <div class="page rightpage">
                <!-- TODO : Display bribes and total paiement -->
                 <?php
                

                $pdo = new \PDO(DSN, USER, PASS);
                $query = "SELECT * FROM bride";
                
                try {
                    $pdo_select = $pdo->prepare($query);
                    $pdo_select->execute();
                    $NbreData = $pdo_select->rowCount();   
                    $rowAll = $pdo_select->fetchAll();
                  } catch (PDOException $e){ echo 'Erreur SQL : '. $e->getMessage().'<br/>'; die(); }
               
                
                if ($NbreData != 0) 
                {
                ?>
                <tfoot>
                    <table border="1">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>payement</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                 
                    foreach ( $rowAll as $row ) 
                    {
                        
                ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['payment']; ?></td>
                        </tr>
                <?php
                    } // fin foreach
                ?>
                    </tbody>
                    </table>
                <?php
                } else { ?>
                  
                <?php
                }
                ?>
            </tfoot>

            
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
