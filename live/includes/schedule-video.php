<?php
require_once('conndb.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST['submit'])) {
    // Details
    $message = "";
    $videoName = $_POST['videoName'];
    $liveOn = $_POST['liveOn'];
    $userTimezone = $_POST['userTimezone'];

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
        // Video already exists, update the liveOn datetime and userTimezone
        $updateQuery = "UPDATE scheduled_videos SET liveOn = ?, userTimezone = ? WHERE videoName = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param("sss", $liveOn, $userTimezone, $videoName);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduling updated successfully!";
    } else {
        // Video doesn't exist, insert a new record
        // Insert the user's timezone and the converted "liveOn" datetime into the database
        $insertQuery = "INSERT INTO scheduled_videos (videoName, liveOn, scheduledAt, userTimezone) VALUES (?, ?, NOW(), ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("sss", $videoName, $liveOnUTC, $userTimezone);
        $stmt->execute();
        $stmt->close();
        $message = "Video scheduled successfully!";
    }
}

// Display the message in an alert
echo '<script type="text/javascript">
    alert("' . $message . '");
</script>';

// Delay the redirection after the alert is closed
echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";
    }, 1000); // Delay in milliseconds (1 second in this example)
</script>';
