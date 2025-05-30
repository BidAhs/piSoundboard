<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== 'LoggedIn') {
    echo '<a href="http://10.80.59.237/login.php">You are not logged in. Login instead</a>';
    die();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>SOUNDBOARD - Play Sound</title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body>
    <h1>Soundboard</h1>

    <div class="center-wrapper">
        <div class="wrapper">
            <div class="container">
                <?php
                $pdo = new PDO('sqlite:../sql/sounds.db');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM sounds WHERE userName = :username";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':username' => $username]);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $result) {
                    $soundName = htmlspecialchars($result['sound']);
                    $filePath = htmlspecialchars($result['filePath']);
                    
                    echo "<div class='sound-box' onclick=\"playSoundOnPi('$filePath')\">$soundName</div>";
                }
            ?>
            </div>
        </div>
    </div>

    <script>
        function playSoundOnPi(file) {
            fetch('playSound.php?file=' + encodeURIComponent(file))
            .then(response => response.text())
            .then(text => {
                console.log(text);
            })
        }
    </script>
</body>
</html>

