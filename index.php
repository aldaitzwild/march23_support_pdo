<?php
    $pdo = new PDO(
        'mysql:host=localhost;dbname=support;charset=utf8',
        'root',
        'root'
    );

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = array_map('trim', $_POST);

        if(!isset($data['destination']) || 
            !in_array($data['destination'], ['mountain', 'sea', 'country'])) {
                echo "Nope !";
                die();
        }

        $query = 'INSERT INTO vote (destination) VALUES (:destination);';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':destination', $data['destination'], PDO::PARAM_STR);
        $statement->execute();
    }

    $querySelect = 'SELECT * FROM vote;';
    $statementSelect = $pdo->query($querySelect);
    $votes = $statementSelect->fetchAll();

    $countVotes = [
        'mountain' => 0,
        'sea' => 0,
        'country' => 0,
    ];


    foreach($votes as $vote) {
        $countVotes[$vote['destination']] += 1;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinions clicker</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>L'heure du choix !</h1>

    <main>
        <div class="choice mountain">
            <div class="counter"><?= $countVotes['mountain'] ?></div>
            <p>Montagne</p>
            <form method="post">
                <input type="hidden" name="destination" value="mountain">
                <button>Voter</button>
            </form>
        </div>

        <div class="choice sea">
            <div class="counter"><?= $countVotes['sea'] ?></div>
            <p>Mer</p>
            <form method="post">
                <input type="hidden" name="destination" value="sea">
                <button>Voter</button>
            </form>
        </div>

        <div class="choice country">
            <div class="counter"><?= $countVotes['country'] ?></div>
            <p>Campagne</p>
            <form method="post">
                <input type="hidden" name="destination" value="country">
                <button>Voter</button>
            </form>
        </div>
    </main>
    
</body>
</html>