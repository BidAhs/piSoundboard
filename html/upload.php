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
    </head>
    <body>
        <h1>UPLOAD NEW SOUNDS</h1>

        <h2>Upload New Sound</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="soundName">Sound Name:</label>
            <input type="text" name="soundName" id="soundName" required><br><br>

            <label for="soundFile">Sound File:</label>
            <input type="file" name="soundFile" id="soundFile" accept="audio/*" required><br><br>

            <input type="submit" name="upload" value="Upload Sound">
        </form>

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
    </body>
</html>
