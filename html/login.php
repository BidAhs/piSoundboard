<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    $_SESSION['logged'] = 'LoggedOut'; 
?>

<html lang="en">
    <head>
        <title>SOUNDBOARD - Login Page</title>
        <style>
            body { background: lightblue; }
 
            #login {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>
    <body>
        <form method="POST" action="login.php">
            <div id="login">
                Username: <input type="text" name="user" required><br>
                Password: <input type="password" name="pass" required><br>
                <input type="submit" value="Submit"><br>
            </div>
        </form>

        <?php
            if (isset($_POST["user"]) && isset($_POST["pass"])) {
                $userEntered = $_POST["user"];
                $passEntered = $_POST["pass"];

                $pdo = new PDO('sqlite:../sql/users.db');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT Password FROM users WHERE userName = :user";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user' => $userEntered]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);


                if ($row) {
                    if ($passEntered === $row['Password']) {
                        $_SESSION['username'] = $userEntered;
                        $_SESSION['logged'] = 'LoggedIn';
                        header("Location: http://localhost/upload.php");
                        exit;
                    } else {
                        echo "<p>Wrong password</p>";
                    }
                } else {
                    echo "<p>User not found</p>";
                }
            }
        ?>
    </body>
</html>

<!-- sudo apt update
sudo apt install php-sqlite3
sudo systemctl restart apache2 -->