<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('conndb.php');
date_default_timezone_set('UTC');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $message = "";

    // Details
    $videoName = $_POST['videoName'];
    $liveOn = $_POST['liveOn'] ? $_POST['liveOn'] : "";
    $userTimezone = $_POST['userTimezone'] ? $_POST['userTimezone'] : "";
    $videoURL = $_POST['url'] ? $_POST['url'] : "";
    $shortCTA = $_POST['shortCTA'] ? $_POST['shortCTA'] : "";
    $longCTA = $_POST['longCTA'] ? $_POST['longCTA'] : "";
    $thirdCTA = $_POST['thirdCTA'] ? $_POST['thirdCTA'] : "";
    $shortCTA_BTN = $_POST['shortCTA_BTN'] ? $_POST['shortCTA_BTN'] : "";
    $longCTA_BTN = $_POST['longCTA_BTN'] ? $_POST['longCTA_BTN'] : "";
    $thirdCTA_BTN = $_POST['thirdCTA_BTN'] ? $_POST['thirdCTA_BTN'] : "";
    $CTA_video = $_POST['CTA_video'] ? $_POST['CTA_video'] : "";
    $liveEndTime = $_POST['liveEndTime'] ? $_POST['liveEndTime'] : "";
    $liveEndDate = $_POST['liveEndDate'] ? $_POST['liveEndDate'] : "";
    $frequency = $_POST['liveFrequency'] ? $_POST['liveFrequency'] : "";

    // Combine date, start time, and end time into a single datetime
    $liveDate = $_POST['liveDate'];
    $liveStartTime = $_POST['liveStartTime'];
    $liveEndTime = $_POST['liveEndTime'];

    // Combine date and time for start
    $combinedStartDateTime = $_POST['liveDate'] . ' ' . $_POST['liveStartTime'];

    // Combine date and time for end 
    $combinedEndDateTime = $_POST['liveEndDate'] . ' ' . $_POST['liveEndTime'];

    // Convert to DateTime objects
    $liveOnObj = new DateTime($combinedStartDateTime, new DateTimeZone($userTimezone));
    $endDateTimeObj = new DateTime($combinedEndDateTime, new DateTimeZone($userTimezone));

    // Format as needed
    $liveOn = $liveOnObj->format('Y-m-d H:i:s');
    $endDate = $endDateTimeObj->format('Y-m-d H:i:s');

    // Check if the videoName exists
    $query = "SELECT * FROM scheduled_videos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Video already exists, update the liveOn datetime, userTimezone, and videoURL
        $updateQuery = "UPDATE scheduled_videos SET liveOn = ?, userTimezone = ?, videoName = ?, videoURL = ?, shortCTA = ?, longCTA = ?, thirdCTA = ?, shortCTA_BTN = ?, longCTA_BTN = ?, thirdCTA_BTN = ?, CTA_video = ?, endDate = ?, frequency = ? WHERE id = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param("ssssssssssssss", $liveOn, $userTimezone, $videoName, $videoURL, $shortCTA, $longCTA, $thirdCTA, $shortCTA_BTN, $longCTA_BTN, $thirdCTA_BTN, $CTA_video, $endDate, $frequency, $id);
        $stmt->execute();

        // Check if the update query was successful
        if ($stmt->affected_rows > 0) {
            $message = "Video updated successfully!";
        } else {
            $message = "Failed to update video. SQL Error: " . $stmt->error;
        }
    } else {
        // Video doesn't exist, insert a new record
        $insertQuery = "INSERT INTO scheduled_videos (videoName, liveOn, scheduledAt, userTimezone, videoURL, shortCTA, longCTA, thirdCTA, shortCTA_BTN, longCTA_BTN, thirdCTA_BTN, CTA_video, endDate, frequency) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("ssssssssssssss", $videoName, $liveOn, $userTimezone, $videoURL, $shortCTA, $longCTA, $thirdCTA, $shortCTA_BTN, $longCTA_BTN, $thirdCTA_BTN, $CTA_video, $endDate, $frequency);
        $stmt->execute();

        // Check if the insert query was successful
        if ($stmt->affected_rows > 0) {
            $message = "Video scheduled successfully!";
        } else {
            $message = "Failed to schedule video. SQL Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $message = "";
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if (!empty($id)) {
        // Continue with the delete process
        $deleteQuery = "DELETE FROM scheduled_videos WHERE id = ?";
        $stmt = $mysqli->prepare($deleteQuery);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // Check the affected rows before closing the statement
        if ($stmt->affected_rows > 0) {
            // Rows were deleted, you can set a success message
            $message = "Video deleted successfully!";
        } else {
            // No rows were deleted, you can set an error message
            $message = "No matching video found for deletion. SQL Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $message = "Invalid ID for deletion.";
    }
}

// Display the message in an alert
echo '<script type="text/javascript">
    alert("' . $message . '");
</script>';

// Delay the redirection after the alert is closed
echo '<script type="text/javascript">
    setTimeout(function() {
        window.history.go(-2);
    }, 1000); // Delay in milliseconds (1 second in this example)
</script>';
?>
