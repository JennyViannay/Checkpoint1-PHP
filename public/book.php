<?php
require_once 'connec.php';
$pdo = new PDO(DSN,USER,PASS);
if($pdo === false) {
    echo "Connection error :" . $pdo->error_log();
}
$query = $pdo->prepare("SELECT * FROM bride");
$querySelect = $query->execute();
$bride = $query->fetchAll();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['name']) && !empty($_POST['payment'])) {
        try {
            $statement = $pdo->prepare('INSERT INTO bride (name, payment) VALUES (:name, :payment)');

            $statement->execute([
                'name' => $_POST['name'],
                'payment' => $_POST['payment']
                ]);
            return header('Location: http://localhost:8000/public/book.php');
        } catch (PDOException $event){
            $error = $event->getMessage();
        }
    }
}
/*if ((isset($_POST['send'])) && !empty($_POST['name']) && !empty($_POST['payment']) && $_POST['payment']>0){
$name = $_POST['name'];
$payment = $_POST['payment'];
$query = $pdo->prepare("INSERT INTO bride (name, payment) values ('$name', '$payment')");
$query->bindValue($name, $_POST['name'], PDO::PARAM_STR);
$query->bindValue($payment, $_POST['payment'], PDO::PARAM_INT);
$queryInsert = $query->execute();
$queryInsert = $query->execute();
if ($queryInsert = true && !empty($_POST['name']) && !empty($_POST['payment']) && $_POST['payment'] > 0){
    $delai = 1;
    $url = "http://localhost:8000/book.php";
    header("Refresh: $delai;url=$url");
}else{
    $error['payment'] = "Don't try to fuck me boy/girl, give me some money ! ";
    $error['name'] = "I don't take money from anonymous guys, sorry man/girl..";
}
}*/
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
                <td><?= $bride['name']; ?></td>
                <td><?= $bride['payment']; ?></td>
            </tr>
            </thead>
            <?php
              } 
            ?>
            <tbody>
                <tr>
                    <td> TOTAL : <?= $total?></td>
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