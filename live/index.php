<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN link -->
  <title>Livestream Viewer</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-9 livestream-container">
        <div class="video-container">
          <div class="video-wrapper">
            <?php
              // Get the value of the "url" parameter from the query string
              $videoUrl = isset($_GET['url']) ? $_GET['url'] : '';

              // Output the video element with the dynamically set source
              echo '<video id="livestream-video" autoplay oncontextmenu="return false;">';
              echo '<source src="../'. $videoUrl . '" type="video/mp4">';
              echo 'Your browser does not support the video tag.';
              echo '</video>';
            ?>
            <div class="live-box">LIVE</div>
            <button id="play-button" class="play-button"><i class="fas fa-play"></i></button>
          </div>
        </div>        
      </div>
      <div class="col-md-3 comments-container">
        <div class="stream-info">
          <h2>Live Stream Title</h2>
          <div class="streamers-info d-flex">
            <div class="comment-avatar me-2">
              <img src="img/apostle.png" alt="Apostle's profile picture">
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
</html>
