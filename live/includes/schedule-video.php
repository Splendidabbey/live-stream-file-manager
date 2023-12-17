<?php
require_once('conndb.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST['submit'])) {
    // Details
    $message = "";
    $videoName = $_POST['videoName'];
    $liveOn = $_POST['liveOn'];
    $userTimezone = $_POST['userTimezone'];
    $videoURL = $_POST['url'];

    // Convert the "liveOn" datetime to UTC before storing it in the database
    $userTimezoneObj = new DateTimeZone($userTimezone);
    $liveOnObj = new DateTime($liveOn);
    $liveOnObj->setTimezone(new DateTimeZone('UTC'));
    $liveOnUTC = $liveOnObj->format('Y-m-d H:i:s');

    // Check if the videoName exists
    $query = "SELECT * FROM scheduled_videos WHERE videoName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $videoName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Video already exists, update the liveOn datetime, userTimezone, and videoURL
        $updateQuery = "UPDATE scheduled_videos SET liveOn = ?, userTimezone = ?, videoURL = ? WHERE videoName = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param("ssss", $liveOn, $userTimezone, $videoURL, $videoName);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduling updated successfully!";
    } else {
        // Video doesn't exist, insert a new record
        // Insert the user's timezone, converted "liveOn" datetime, and videoURL into the database
        $insertQuery = "INSERT INTO scheduled_videos (videoName, liveOn, scheduledAt, userTimezone, videoURL) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("ssss", $videoName, $liveOn, $userTimezone, $videoURL);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduled successfully!";
    }
}   else if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST['delete'])) {
    $message = "";
    $videoName = $_POST['videoName'];

    $deleteQuery = "DELETE FROM scheduled_videos WHERE videoName = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("s", $videoName);
    $stmt->execute();

    // Check the affected rows before closing the statement
    if ($stmt->affected_rows > 0) {
        // Rows were deleted, you can set a success message
        $message = "Video deleted successfully!";
    } else {
        // No rows were deleted, you can set an error message
        $message = "No matching video found for deletion.";
    }

    $stmt->close();

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
