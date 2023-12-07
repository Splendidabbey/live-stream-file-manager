<?php
require_once('includes/conndb.php');
// Get the user's timezone using JavaScript and add it as a GET parameter
echo '<script>
const urlParams = new URLSearchParams(window.location.search);
const userTimezone = urlParams.get("userTimezone");

if (!userTimezone) {
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const newUrl = window.location.href + (window.location.search ? "&" : "?") + "userTimezone=" + encodeURIComponent(timezone);
    window.location.href = newUrl;
}
</script>
';
if ($_SERVER['REQUEST_METHOD'] === 'POST' & isset($_POST['submit'])) {
    $videoName = isset($_POST['video_name']) ? $_POST['video_name'] : '';
    $ctaValue = isset($_POST['cta_value']) ? $_POST['cta_value'] : '';
    $userTimeZone = isset($_GET['userTimezone']) ? $_GET['userTimezone'] : ''; // Assuming you have a field for userTimeZone in your form.

    if (!empty($videoName) && !empty($ctaValue)) {
        if ($ctaValue == 'type in your CTA') {
            echo '<script>alert("you have not added a CTA")</script>';
            echo '<script>window.history.go(-1);</script>';
        } else {
            // Check if video_name already exists in the database
            $checkQuery = "SELECT * FROM videos_cta WHERE video_name = ?";
            $stmt = $mysqli->prepare($checkQuery);
            $stmt->bind_param("s", $videoName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Video name exists, so update the existing record
                $updateQuery = "UPDATE videos_cta SET cta_value = ?, userTimeZone = ?, createdAt = NOW() WHERE video_name = ?";
                $stmt = $mysqli->prepare($updateQuery);
                $stmt->bind_param("sss", $ctaValue, $userTimeZone, $videoName);

                if ($stmt->execute()) {
                    // Data updated successfully, redirect back to the previous page
                    echo '<script>alert("Data updated successfully")</script>';
                    echo '<script>
                            setTimeout(function() {
                                window.history.go(-3);
                            }, 2000); 
                        </script>';
                    exit; // Exit to prevent further output
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to update data']);
                }
            } else {
                // Insert new data into the database
                $insertQuery = "INSERT INTO videos_cta (video_name, cta_value, userTimeZone, createdAt) VALUES (?, ?, ?, NOW())";
                $stmt = $mysqli->prepare($insertQuery);
                $stmt->bind_param("sss", $videoName, $ctaValue, $userTimeZone);

                if ($stmt->execute()) {
                    // Data saved successfully, redirect back to the previous page
                    echo '<script>alert("Data saved successfully")</script>';
                    echo '<script>
                            setTimeout(function() {
                                window.history.go(-3);
                            }, 2000); 
                        </script>';
                    exit; // Exit to prevent further output
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to save data']);
                }
            }

            // Close the database connection
            $stmt->close();
        }
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
                <input class="btn btn-primary mb-3" name="submit" type="submit" value="Submit">
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
