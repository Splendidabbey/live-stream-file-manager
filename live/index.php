<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

// Get the value of the "url" parameter from the query string
$videoUrl = isset($_GET['url']) ? $_GET['url'] : '';
$videoName = isset($_GET['url']) ? $_GET['video_name'] : '';

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN link -->
  <title>Livestream Viewer</title>
</head>
<body>';
  // Check if the videoName exists
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
      if(isLiveOnInPast($liveOn, $userTimezone)) {
        echo '<div class="container">
          <div class="row">
            <div class="col-md-9 livestream-container">
              <div class="video-container">
                <div class="video-wrapper">';
    
        // Output the video element with the dynamically set source
        echo '<video id="livestream-video" autoplay oncontextmenu="return false;">';
        echo '<source src="../'. $videoUrl . '" type="video/mp4">';
        echo 'Your browser does not support the video tag.';
        echo '</video>';
        
        echo '<div class="live-box">LIVE</div>
                    <button id="play-button" class="play-button"><i class="fas fa-play"></i></button>
                  </div>
                </div>        
              </div>
              <div class="col-md-3 comments-container">
                <div class="stream-info">
                  <h2>Live Stream Title</h2>
                  <div class="streamers-info d-flex">
                    <div class="comment-avatar me-2">
                      <img src="img/apostle.png" alt="Apostle\'s profile picture">
                    </div>
                    <p class="me-1 mt-2 text-primary">Apostle </p>
                    <p class="mt-2"> is Live now!</p>
                  </div>
                  <p>Viewers: <span id="viewer-count">0</span></p>
                </div>
                <div class="comments-panel">
                  <ul id="comments-list"></ul>
                  <input type="text" id="comment-input" placeholder="Write a comment...">
                  <button id="comment-button">Comment</button>
                </div>
              </div>
            </div>
          </div>
          <div class="under-div d-grid gap-2 d-md-flex justify-content-md-end">
            <button id="join-button" class="btn btn-success btn-lg m-2" type="button">
              <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
              JOIN
            </button>
          </div>
          <script src="js/script.js"></script>
        </body>
        </html>';
      } else {
        echo `
          <h1>Video is not live yet!</h1>
          <script src="js/script.js"></script>
          </body>
          </html>';
        `;
      }
  } else {
    echo `
      <h1>Video has not been scheduled!</h1>
      <script src="js/script.js"></script>
      </body>
      </html>';
    `;
  }
?>
