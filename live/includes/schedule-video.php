<?php
require_once('conndb.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Details
    $message = "";
    $videoName = $_POST['videoName'];
    $liveOn = $_POST['liveOn'];
    $userTimezone = $_POST['userTimezone'];
    $videoURL = $_POST['url'];
    $shortCTA = $_POST['shortCTA'];
    $longCTA = $_POST['longCTA'];
    $id =$_POST['id'] ? $_POST['id'] : "";
    $thirdCTA = $_POST['thirdCTA'] ? $_POST['thirdCTA'] : "";
    $shortCTA_BTN = $_POST['shortCTA_BTN'] ? $_POST['shortCTA_BTN'] : "";
    $longCTA_BTN = $_POST['longCTA_BTN'] ? $_POST['longCTA_BTN'] : "";
    $thirdCTA_BTN = $_POST['thirdCTA_BTN'] ? $_POST['thirdCTA_BTN'] : "";
    $CTA_video = $_POST['CTA_video'] ? $_POST['CTA_video'] : "";

    // Convert the "liveOn" datetime to UTC before storing it in the database
    $userTimezoneObj = new DateTimeZone($userTimezone);
    $liveOnObj = new DateTime($liveOn);
    $liveOnObj->setTimezone(new DateTimeZone('UTC'));
    $liveOnUTC = $liveOnObj->format('Y-m-d H:i:s');

    // Check if the videoName exists
    $query = "SELECT * FROM scheduled_videos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Video already exists, update the liveOn datetime, userTimezone, and videoURL
        $updateQuery = "UPDATE scheduled_videos SET liveOn = ?, userTimezone = ?, videoName = ?, videoURL = ?, shortCTA = ?, longCTA = ? WHERE id = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param("sssssss", $liveOn, $userTimezone, $videoName, $videoURL, $shortCTA, $longCTA, $id);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduling updated successfully!";
    } else {
        // Video doesn't exist, insert a new record
        // Insert the user's timezone, converted "liveOn" datetime, and videoURL into the database
        $insertQuery = "INSERT INTO scheduled_videos (videoName, liveOn, scheduledAt, userTimezone, videoURL, shortCTA, longCTA) VALUES (?, ?, NOW(), ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("ssssss", $videoName, $liveOn, $userTimezone, $videoURL, $shortCTA, $longCTA);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduled successfully!";
    }
}   else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $message = "";
    $id = $_POST['id'];

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
