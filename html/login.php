<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    $_SESSION['logged'] = 'LoggedOut'; 
?>

<html lang="en">
    <head>
        <title>SOUNDBOARD - Login Page</title>
        <link rel="stylesheet" href="styles/style.css" />
    </head>
    <body>
        <h1>Soundboard Login</h1>

        <div class="center-wrapper">
            <div class="wrapperC">
                <div class="centerC">
                    <form method="POST" action="login.php">
                        <div id="login">
                            <input type="text" name="user" placeholder="USERNAME" required><br><br>
                            <input type="password" name="pass" placeholder="PASSWORD" required><br><br>
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
                                    header("Location: http://10.80.60.120/upload.php");
                                    exit;
                                } else {
                                    echo "<p>Wrong password</p>";
                                }
                            } else {
                                echo "<p>User not found</p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
