<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eddy ענן</title>
    <link rel="shortcut icon" href="https://eddy.42web.io/_0d948940-408a-49b7-a666-9f8dc667055f.ico" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('https://example.com/background-image.jpg'); /* הוסף כאן את כתובת התמונה שתרצה */
            background-size: cover;
            background-attachment: fixed;
        }
        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        li:hover {
            background-color: #f1f1f1;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .message {
            font-size: 16px;
            color: #666;
        }
        img {
            vertical-align: middle;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .info {
            margin: 20px 0;
            font-size: 18px;
            color: #555;
        }
        .search-form {
            margin: 20px 0;
        }
        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 22px); /* Adjust width to fit container */
        }
        .search-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-form input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <img width='50px' height='50px' src='https://eddy.42web.io/_0d948940-408a-49b7-a666-9f8dc667055f.ico' alt="Icon"/>
        <h1>Eddy server</h1>

        <div class="info">
            <p>ברוכים הבאים למערכת אדי שרת . כאן תוכלו לראות את כל הקבצים שהועלו ולבצע חיפושים. אם יש לכם קבצים להוסיף, השתמשו בכפתור למעלה.</p>
        </div>

        <div class="search-form">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="חפש קבצים...">
                <input type="submit" value="חפש">
            </form>
        </div>

        <?php
        $dir = "uploads/";

        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            
            if (count($files) > 0) {
                echo "<ul>";
                foreach ($files as $file) {
                    $safe_file = htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
                    $file_path = htmlspecialchars($dir . $file, ENT_QUOTES, 'UTF-8');
                    echo "<li><a href=\"$file_path\" target=\"_blank\">$safe_file</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='message'>לא נמצאו קבצים בתיקייה.</p>";
            }
        } else {
            echo "<p class='message'>התיקייה לא קיימת.</p>";
        }
        ?>

        <div class="button-container">
            <a href="upload" class="button" target="_blank">הוסף קובץ</a>
            <a href="https://eddy.42web.io" class="button">חזרה לדף הבית</a>
        </div>
    </div>
</body>
</html>
