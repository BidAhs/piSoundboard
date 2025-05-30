<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== 'LoggedIn') {
        echo '<a href="http://10.80.59.237/login.php">You are not logged in. Login instead</a>';
        die();
    }

    $username = $_SESSION['username']; 
?>

<html>
    <head>
        <title>SOUNDBOARD - Upload File</title>
        <link rel="stylesheet" href="styles/style.css" />

    </head>
    <body>
        <h1>UPLOAD NEW SOUNDS</h1>

        <div class="center-wrapper">
            <div class="wrapperC">
                <div class="centerC">
                    <form method="POST" enctype="multipart/form-data" class="upload-form">
                        <label for="soundName"><strong>Sound Name:</strong></label>
                        <input type="text" name="soundName" id="soundName" required>

                        <label for="soundFile"><strong>Sound File:</strong></label>
                        <input type="file" name="soundFile" id="soundFile" accept="audio/*" required>

                        <div class="full-width">
                            <input type="submit" name="upload" value="Upload Sound">
                        </div>
                    </form>
                </div>
                

                <?php
                    $uploadDir = __DIR__ . '/uploads/';
                    $dbPath = realpath(__DIR__ . '/../sql') . '/sounds.db';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $pdo = new PDO('sqlite:' . $dbPath);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    if (isset($_POST['upload'])) {
                        if (!empty($_POST['soundName']) && isset($_FILES['soundFile']) && $_FILES['soundFile']['error'] === UPLOAD_ERR_OK) {
                            $soundName = trim($_POST['soundName']);

                            $fileTmpPath = $_FILES['soundFile']['tmp_name'];
                            $fileName = basename($_FILES['soundFile']['name']);
                            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                            $allowedExts = ['mp3', 'wav'];

                            if (!in_array($fileExt, $allowedExts)) {
                                echo "<p style='color:red;'>Unsupported file type</p>";
                            } else {
                                $safeFileName = uniqid() . '.' . $fileExt;
                                $destination = $uploadDir . $safeFileName;

                                if (move_uploaded_file($fileTmpPath, $destination)) {
                                    $filePathForDB = 'uploads/' . $safeFileName;

                                    $sql = "INSERT INTO sounds (userName, sound, filePath) VALUES (:username, :sound, :filepath)";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
                                        ':username' => $username,
                                        ':sound' => $soundName,
                                        ':filepath' => $filePathForDB
                                    ]);
                                    echo "<p style='color:green;'>Sound uploaded</p>";

                                } else {
                                    echo "<p style='color:red;'>Failed</p>";
                                }
                            }
                        } else {
                            echo "<p style='color:red;'>Please try again</p>";
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
