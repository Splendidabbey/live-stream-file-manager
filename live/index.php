<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

// Get the value of the "url" parameter from the query string
$videoURL = null;
$videoName = null;
$liveOn = null;
$userTimezone = null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $id = $_GET['id'] ? $_GET['id'] : "";
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

$viewerUserTimezone = $_GET['userTimezone'] ? $_GET['userTimezone'] : "";

$content = '
  <h1>Take The Bold Step Into Becoming <br>My Premium Student Where I Show You The Remaining <br>95% I Held Back In The Cause Of The Webinar.</h1>
  <p class="webinar-p">GT Bank: 0257821123<br>
  Obembe Emmanuel</p>

  <h1>Benefit Summary:</h1>
  <ul type="none">
    <li>
      1. Get Personal Mentorship With Me Plus Crazy Profitable Strategies
    </li>
    <li>
      2. How Not To Burn Your Hard Earned Money Again (Easy To Master Strategy)
    </li>
    <li>
      3. How To Be In Control The Markets From Your Desk. (Strategies That Will Give You The Missing Edge Over The Market)
    </li>
    <li>
      4. Crazily Profitable Signals To 20X Your Entire Trading Account.
    </li>
    <li>
      5. Get Access To My Most Profitable Trading Room (Meet With Crazily Profitable Traders). ETC...
    </li>
  </ul><br>
<h1>30DAYS MONEY BACK GUARANTEED</h1>
<p class="webinar-p">Key Into To These Testimonials Of The Transformed Lives With Just ₦50k ($100). Its Time You Took Decisive Action Towards Changing Your Financial Realities.</p>
<p class="webinar-p">GT Bank: 0257821123<br>
Obembe Emmanuel</p>

  <!-- CTA button linked to WhatsApp acc -->
  <a href="https://wa.me/2348136096954" target="_blank" class="cta-button">
    Click here, to send Proof Of Payment👇
  </a>
  <br><br>
  <p class="webinar-p">Unfortunately, this webinar has ended.</p>
';

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
  $queryResult = queryVideoById($mysqli, $id);

  if (!empty($queryResult)) {
      // Process the query result, e.g., display it or perform actions
      foreach ($queryResult as $row) {
          // Access table columns using $row['column_name']
          $videoName = $row['videoName'];
          $liveOn = $row['liveOn'];
          $scheduledAt = $row['scheduledAt'];
          $userTimezone = $row['userTimezone'];
          $videoURL = $row['videoURL'];
      }
      if(isLiveOn($liveOn, $userTimezone) == true) {
        echo '<div class="container">
          <div class="row">
            <div class="col-md-9 livestream-container">
              <div class="video-container">
                <div class="video-wrapper">';
    
        // Output the video element with the dynamically set source
        echo '<video id="livestream-video" autoplay oncontextmenu="return false;">';
        echo '<source src="../'. $videoURL . '" type="video/mp4">';
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
        echo $content;
        if(hasBeenScheduledById($mysqli, $id)) {
          if (!empty($queryResult)) {
            // Process the query result, e.g., display it or perform actions
            foreach ($queryResult as $row) {
                // Access table columns using $row['column_name']
                $videoName = $row['videoName'];
                $liveOn = $row['liveOn'];
                $scheduledAt = $row['scheduledAt'];
                $userTimezone = $row['userTimezone'];
            }
          }
          echo '<p class="webinar-p">This Webinar has been scheduled to hold on <span style="color: #000000;">'. convertToUserTimezone($liveOn, $userTimezone, $viewerUserTimezone) .'</span></p>';
        }
        echo ' 
        </body>
        </html>';
      }
  } else {
    echo $content;
    echo ' 
    </body>
    </html>';
  }
?>
