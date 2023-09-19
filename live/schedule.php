<?php
require_once('includes/conndb.php');
require_once('includes/function.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") $videoName = $_GET['video_name'] ? $_GET['video_name'] : "";
$liveOn = null;
$videoInfo = null;

$queryResult = queryVideo($mysqli, $videoName);

if (!empty($queryResult)) {
    // Process the query result, e.g., display it or perform actions
    foreach ($queryResult as $row) {
        // Access table columns using $row['column_name']
        $videoName = $row['videoName'];
        $liveOn = $row['liveOn'];
        $scheduledAt = $row['scheduledAt'];
        $userTimezone = $row['userTimezone'];
    }
} else {
    http_response_code(404);
}

if (empty(!$videoName)) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Schedule Video for ' . $videoName . '</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .container {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            label {
                font-weight: bold;
            }

            input[type="datetime-local"] {
                width: 100%;
                padding: 8px;
                margin-top: 5px;
                margin-bottom: 10px;
            }

            input[type="submit"] {
                background-color: #007bff;
                color: #fff;
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
        <script>
            // JavaScript to capture the users timezone and add it to the form
            function captureTimezone() {
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                document.getElementById("userTimezone").value = timezone;
            }
        </script>
    </head>
    <body>
        <div class="container">';
            if(hasBeenScheduled($mysqli, $videoName)) {
                echo'
                <h1><span style="color: #198754;">Live</span></live> for <em style="color: #007bff;">"'. $videoName .'"</em> has been scheduled to start '. $liveOn .'</h1>';
                if(isLiveOnInPast($liveOn, $userTimezone)) {
                    echo '<em style="color: #198754;">video is currently live</em>';
                } else {
                    echo '<em style="color: #FF0000;">video is not currently live</em>';
                }
            } else {
                echo'
                <h1>Schedule <span style="color: #198754;">Live</span></live> for <em style="color: #007bff;">"'. $videoName .'"</em></h1>';
            }
            
            if (isset($message)) {
                echo '<p>' . $message . '</p>';
            }

            echo '
            <form action="includes/schedule-video.php" method="post">
                <input type="hidden" name="videoName" value="' . $videoName . '">
                <label for="liveOn">Select Date and Time:</label>
                <input type="datetime-local" name="liveOn" required>
                <input type="hidden" name="userTimezone" id="userTimezone" value="">
                <input type="submit" name="submit" value="Schedule/Update" onclick="captureTimezone()">
            </form>
        </div>
    </body>
    </html>
    ';
}
?>

