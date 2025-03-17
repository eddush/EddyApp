<?php
// Directory to save uploaded files
$targetDir = "post/";

// Handle file uploads from computer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileToUpload']) && isset($_POST['fileName'])) {
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $newFileName = $_POST['fileName'];
        $targetFilePath = $targetDir . $newFileName . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
            echo "הקובץ הועלה בהצלחה!";
        } else {
            echo "שגיאה בהעלאת הקובץ.";
        }
    }

    // Handle file uploads from URL
    if (isset($_POST['fileUrl']) && isset($_POST['fileNameUrl'])) {
        $fileUrl = $_POST['fileUrl'];
        $newFileName = $_POST['fileNameUrl'];
        $targetFilePath = $targetDir . $newFileName;

        // Download the file from the URL
        $fileContent = file_get_contents($fileUrl);
        if ($fileContent === false) {
            echo "שגיאה בהורדת הקובץ מהקישור.";
            exit;
        }

        // Determine the file extension from the URL
        $fileExtension = pathinfo(parse_url($fileUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
        if ($fileExtension) {
            $targetFilePath .= '.' . $fileExtension;
        }

        // Save the downloaded file to the target directory
        if (file_put_contents($targetFilePath, $fileContent)) {
            echo "הקובץ מהקישור הועלה בהצלחה!";
        } else {
            echo "שגיאה בהעלאת הקובץ מהקישור.";
        }
    }
}
?>
