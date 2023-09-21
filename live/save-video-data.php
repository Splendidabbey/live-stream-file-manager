<?php
require_once('includes/conndb.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $videoName = isset($_POST['video_name']) ? $_POST['video_name'] : '';
    $ctaValue = isset($_POST['cta_value']) ? $_POST['cta_value'] : '';

    if (!empty($videoName) && !empty($ctaValue)) {
        // Check if video_name already exists in the database
        $checkQuery = "SELECT * FROM videos_cta WHERE video_name = ?";
        $stmt = $mysqli->prepare($checkQuery);
        $stmt->bind_param("s", $videoName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            http_response_code(400);
            echo json_encode(['error' => 'You have added a CTA value for this video before. Please rename the video.']);
            exit; // Exit to prevent further processing
        }

        // Insert new data into the database
        $insertQuery = "INSERT INTO videos_cta (video_name, cta_value, timestamp) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $timestamp = time();
        $stmt->bind_param("sss", $videoName, $ctaValue, $timestamp);

        if ($stmt->execute()) {
            // Data saved successfully, redirect back to the previous page
            echo '<script>window.history.go(-2);</script>';
            exit; // Exit to prevent further output
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save data']);
        }

        // Close the database connection
        $stmt->close();
        $mysqli->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Both video_name and cta_value are required']);
    }
} else {
    $videoName = isset($_GET['video_name']) ? $_GET['video_name'] : '';
    $ctaValue = isset($_GET['cta_value']) ? $_GET['cta_value'] : '';
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="centered-form">
            <form style="max-width: 80vw;" method="post" action="">
                <div class="mb-3">
                    <label for="video_name" class="form-label">Video Name:</label>
                    <input type="text" class="form-control" id="video_name" name="video_name" value="<?= htmlspecialchars($videoName) ?>" readonly><br>
                </div>
                <div class="mb-3">
                    <label for="cta_value" class="form-label">CTA Value:</label>
                    <input type="text" class="form-control" id="cta_value" name="cta_value" value="<?= htmlspecialchars($ctaValue) ?>"><br>
                </div>
                <input class="btn btn-primary mb-3" type="submit" value="Submit">
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
