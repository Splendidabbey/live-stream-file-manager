<?php
require_once('includes/conndb.php');
require_once('includes/function.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    $videoName = $_GET['video_name'] ? $_GET['video_name'] : "";
    $url = $_GET['url'] ? $_GET['url'] : "";
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
}

$liveOn = null;
$videoInfo = null;

$queryResult = queryVideo($mysqli, $videoName);

$viewerUserTimezone = $_GET['userTimezone'] ? $_GET['userTimezone'] : "";

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN link -->
        <title>Schedule Video for ' . $videoName . '</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .container {
                max-width: 80vw;
                min-height: 50vh;
                margin: 10vh auto;
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
            button {
                background-color: #00ff00;
                color: #fff;
                padding: 5px 10px;
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
        <div class="row mt-3">
            <div class="col-12">
                <a href="../"><i class="fas fa-arrow-left me-3"></i>back to home</a>
            </div>
        </div>
        <div class="container">';
            if(hasBeenScheduled($mysqli, $videoName)) {
                echo'
                <h1><span style="color: #198754;">Live</span></live> for <em style="color: #007bff;">"'. $videoName .'"</em> has been scheduled to start '. convertToUserTimezone($liveOn, $userTimezone, $viewerUserTimezone) .'</h1>';
                if(isLiveOn($liveOn, $userTimezone)) {
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
                <input type="hidden" name="url" value="' . $url . '">
                <label for="liveOn">Select Date and Time:</label>
                <input type="datetime-local" name="liveOn" required>
                <input type="hidden" name="userTimezone" id="userTimezone" value="">
                <input type="submit" name="submit" value="Schedule/Update" onclick="captureTimezone()">
            </form>';
            if(hasBeenScheduled($mysqli, $videoName)) {
                echo '
                <form action="includes/schedule-video.php" method="post">
                    <input type="hidden" name="videoName" value="' . $videoName . '">
                    <input style="color: #ffffff; background-color: #ff0000;" type="submit" name="delete" value="Delete Schedule">
                </form>';
            }
            echo '
            <input type="text" value="'. $protocol .'://'. $_SERVER['HTTP_HOST'] .'/live/?id='. getVideoIdByName($mysqli, $videoName) .'" id="myInput">
            <button onclick="myFunction()">Live Url</button>
            ';
        echo'
        </div>
    </body>
    </html>
    ';
}
?>

<script>
function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}
</script>


