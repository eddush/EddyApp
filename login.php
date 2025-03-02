<?php
session_start();

// חיבור למסד הנתונים
$host = 'sql208.infinityfree.com';
$dbname = 'if0_36356996_acunt';
$user = 'if0_36356996';
$pass = '8WUzmkgqMdUAY';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, password, profile_image FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $profile_image);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            echo "Login successful!";

            // הגדרת עוגיות לשם המשתמש, תמונת פרופיל ועוגיית 'myCookie'
            setcookie("myname", $username, time() + 604800, "/");
            setcookie("profile_image", $profile_image, time() + 604800, "/"); // שמירה בקישור לתמונה
            setcookie("myCookie", "1", time() + 604800, "/");

            header("Location: https://eddy.42web.io");
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
    
    $stmt->close();
}

$conn->close();
?>
