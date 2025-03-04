<?php
session_start();

// קוד PHP שמבצע עיבוד או שליפת נתונים
$greeting = "שלום, ברוך הבא לבלוג שלי!";
?>

<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eddy cat</title>
    <link rel="shortcut icon" href="https://eddy.42web.io/_0d948940-408a-49b7-a666-9f8dc667055f.ico" />
    <style>
        /* עיצוב כללי */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            direction: rtl;
            text-align: right;
            transition: background-color 0.3s ease;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .content {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form input, form textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 1.1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #45a049;
        }

        .post {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 15px;
        }

        .post-content {
            font-size: 1.2em;
            color: #555;
        }

        .post-views {
            font-size: 1em;
            color: #888;
            margin-top: 10px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }

        /* מצב כהה */
        .dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .dark-mode header, .dark-mode footer {
            background-color: #1e1e1e;
        }

        .dark-mode form input, .dark-mode form textarea {
            background-color: #333;
            color: #fff;
            border: 1px solid #444;
        }

        .dark-mode form button {
            background-color: #6200ea;
        }

        .dark-mode form button:hover {
            background-color: #3700b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Eddy cat</h1>
    <button id="darkModeToggle">הגדר מצב כהה/בהיר</button>
</header>

<div class="content">
    <h2>הוסף פוסט חדש</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="הכנס את שמך" required>
        <input type="text" name="title" placeholder="כותרת הפוסט" required>
        <textarea name="content" rows="6" placeholder="תוכן הפוסט" required></textarea>
        <button type="submit">שמור פוסט</button>
    </form>

    <h2>הפוסטים האחרונים</h2>
    <?php
    $postsDir = 'posts';
    if (!is_dir($postsDir)) {
        mkdir($postsDir, 0777, true);
    }

    $posts = array_diff(scandir($postsDir), array('.', '..'));

    foreach ($posts as $post) {
        $post_file = $postsDir . '/' . $post;
        $post_title = pathinfo($post, PATHINFO_FILENAME);

        // ניהול צפיות - זיהוי לפי SESSION/COOKIE
        $post_id = md5($post_title);
        $views_file = 'views/' . $post . '.views';

        if (!file_exists($views_file)) {
            file_put_contents($views_file, 0);
        }

        $views = (int) file_get_contents($views_file);

        if (!isset($_SESSION['viewed_posts'][$post_id]) && !isset($_COOKIE["viewed_$post_id"])) {
            $views++;
            file_put_contents($views_file, $views);
            $_SESSION['viewed_posts'][$post_id] = true;
            setcookie("viewed_$post_id", "true", time() + (86400 * 30), "/"); // תוקף ל-30 יום
        }

        $post_content = file_get_contents($post_file);
        echo "<div class='post'>
                <div class='post-title'>" . ucfirst(str_replace('_', ' ', $post_title)) . "</div>
                <div class='post-content'>" . nl2br($post_content) . "</div>
                <div class='post-views'>צפיות: $views</div>
              </div>";
    }
    ?>
</div>

<footer>
    <p>&copy; 2025 הבלוג שלי | כל הזכויות שמורות</p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;

        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        darkModeToggle.addEventListener("click", function () {
            body.classList.toggle("dark-mode");
            
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("darkMode", "enabled");
            } else {
                localStorage.setItem("darkMode", "disabled");
            }
        });
    });
</script>

</body>
</html>
