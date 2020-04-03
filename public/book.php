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
        include 'header.php'; 
        require_once '../connec.php';

        $pdo = new PDO(DSN,USER,PWD);
        if($pdo === false){
            echo 'Connection Error :' .$pdo->error_log();
        } else {
                // name & payment from DB
                $getAllBribes = "SELECT * FROM bribe";
                try {
                    $sendRequest = $pdo->query($getAllBribes);
                    $bribes = $sendRequest->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $error = $e->getMessage();
                }
            }
          
      
        

    ?>

    <main class="container">

        <section class="desktop">
            <img src="image/whisky.png" alt="a whisky glass" class="whisky" />
            <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky" />
            
            <div class="pages">
                <div class="page leftpage">
                    Add a bribe

                    <!-- TODO : Form -->
                    <form method="POST">
                        Name:<input type="text" id="name" name="name" placeholder="name">
                        <br><br>
                        Payement<input type="text" id="payment" name="payment" placeholder="payment">
                        <br><br>
                        <input type="submit" name="submit" value="Submit">
                    </form>

                </div>
        
                <div class="page rightpage">
                    <!-- TODO : Display bribes and total paiement -->             
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>$$$$</th>
                        </tr>
                        <?php foreach($bribes as $bribe){ ?>
                        <tr>
                            <td><?= $bribe['name'] ?></td> 
                            <td><?= $bribe['payment']?></td>
                        </tr>
                        <?php
                      }
                     ?>
                    </table>
                    
                </div>
            </div>
        
            <a href="book.php"></a>
            
            <img src="image/inkpen.png" alt="an ink pen" class="inkpen" />
        </section>
    </main>
</body>

</html>