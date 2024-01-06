<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OneWebinar- Video uploader</title>
  <link rel="stylesheet" href="./style.css">
  <style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600);

    * {
      margin:0;
      padding:0;
      box-sizing:border-box;
      -webkit-box-sizing:border-box;
      -moz-box-sizing:border-box;
      -webkit-font-smoothing:antialiased;
      -moz-font-smoothing:antialiased;
      -o-font-smoothing:antialiased;
      font-smoothing:antialiased;
      text-rendering:optimizeLegibility;
    }

    body {
      font-family:"Open Sans", Helvetica, Arial, sans-serif;
      font-weight:300;
      font-size: 12px;
      line-height:30px;
      color:#777;
      background:#0CF;
    }

    .container {
      max-width:400px;
      width:100%;
      margin:0 auto;
      position:relative;
    }

    #contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea, #contact button[type="submit"] { font:400 12px/16px "Open Sans", Helvetica, Arial, sans-serif; }

    #contact {
      background:#F9F9F9;
      padding:25px;
      margin:50px 0;
    }

    #contact h3 {
      color: #F96;
      display: block;
      font-size: 30px;
      font-weight: 400;
    }

    #contact h4 {
      margin:5px 0 15px;
      display:block;
      font-size:13px;
    }

    fieldset {
      border: medium none !important;
      margin: 0 0 10px;
      min-width: 100%;
      padding: 0;
      width: 100%;
    }

    #contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea {
      width:100%;
      border:1px solid #CCC;
      background:#FFF;
      margin:0 0 5px;
      padding:10px;
    }

    #contact input[type="text"]:hover, #contact input[type="email"]:hover, #contact input[type="tel"]:hover, #contact input[type="url"]:hover, #contact textarea:hover {
      -webkit-transition:border-color 0.3s ease-in-out;
      -moz-transition:border-color 0.3s ease-in-out;
      transition:border-color 0.3s ease-in-out;
      border:1px solid #AAA;
    }

    #contact textarea {
      height:100px;
      max-width:100%;
      resize:none;
    }

    #contact button[type="submit"] {
      cursor:pointer;
      width:100%;
      border:none;
      background:#0CF;
      color:#FFF;
      margin:0 0 5px;
      padding:10px;
      font-size:15px;
    }

    #contact button[type="submit"]:hover {
      background:#09C;
      -webkit-transition:background 0.3s ease-in-out;
      -moz-transition:background 0.3s ease-in-out;
      transition:background-color 0.3s ease-in-out;
    }

    #contact button[type="submit"]:active { box-shadow:inset 0 1px 3px rgba(0, 0, 0, 0.5); }

    #contact input:focus, #contact textarea:focus {
      outline:0;
      border:1px solid #999;
    }
    ::-webkit-input-placeholder {
    color:#888;
    }
    :-moz-placeholder {
    color:#888;
    }
    ::-moz-placeholder {
    color:#888;
    }
    :-ms-input-placeholder {
    color:#888;
    }
  </style>
  <!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/hid5n8nqdv933fhssh9hla40p209874s1i36ttd5edr0xn76/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    // JavaScript to capture the users timezone and add it to the form
    function captureTimezone() {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById("userTimezone").value = timezone;
    }
  </script>
  <?php
  require_once('includes/conndb.php');
  require_once('includes/function.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

  $id = $_GET['id'] ? $_GET['id'] : "";
  // $url = $_GET['url'] ? $_GET['url'] : "";
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

$queryResult = queryVideoById($mysqli, $id);

$viewerUserTimezone = $_GET['userTimezone'] ? $_GET['userTimezone'] : "";

if (!empty($queryResult)) {
    // Process the query result, e.g., display it or perform actions
    foreach ($queryResult as $row) {
        // Access table columns using $row['column_name']
        $videoName = $row['videoName'];
        $liveOn = $row['liveOn'];
        $scheduledAt = $row['scheduledAt'];
        $userTimezone = $row['userTimezone'];
        $videoURL = $row['videoURL'];
        $shortCTA = $row['shortCTA'];
        $longCTA = $row['longCTA'];
        $id = $row['id'];
    }
} else {
    http_response_code(404);
}
}
  ?>
  <script>
    document.addEventListener("contextmenu", event => event.preventDefault());
  </script>
</head>
<body style="overflow: auto;">
<!-- partial:index.partial.html -->
<div class="container">  
  <form id="contact" action="includes/schedule-video.php" method="post" style="overflow-x: auto;">
    <h3>Upload Your videos</h3>
    <h4>fill in all necessary fields</h4>
    <fieldset>
      <input name="videoName" placeholder="video name" value="<?php echo $videoName; ?>" type="text" required>
    </fieldset>
    <fieldset>
      <input name="url" placeholder="video url" value="<?php echo $videoURL; ?>" type="text" required>
    </fieldset>
    <fieldset>
      <?php
      if(hasBeenScheduled($mysqli, $videoName)) {
        echo '
            <h1><span style="color: #198754;">Live</span></live> for <em style="color: #007bff;">"' . $videoName . '"</em> has been scheduled to start ' . convertToUserTimezone($liveOn, $userTimezone, $viewerUserTimezone) . '. You can update it below.</h1>';
      }
      ?>
      <h2>Select Live date and time</h2>
      <input name="liveOn" type="datetime-local" name="liveOn">
    </fieldset>
    <fieldset>
      <label for="timezone">Select Time Zone:</label>
      <select id="timezone" name="userTimezone'">
          <option value="Africa/Lagos" selected>Africa/Lagos (Default)</option>
          <option value="Asia/Qatar">Asia/Qatar</option>
          <option value="America/New_York">America/New_York</option>
          <option value="Europe/London">Europe/London</option>
          <option value="Asia/Tokyo">Asia/Tokyo</option>
          <option value="Australia/Sydney">Australia/Sydney</option>
          <option value="America/Los_Angeles">America/Los_Angeles</option>
          <option value="Europe/Paris">Europe/Paris</option>
          <option value="Asia/Dubai">Asia/Dubai</option>
          <option value="America/Chicago">America/Chicago</option>
          <option value="Asia/Hong_Kong">Asia/Hong_Kong</option>
          <option value="Europe/Berlin">Europe/Berlin</option>
          <option value="America/Toronto">America/Toronto</option>
          <option value="Asia/Singapore">Asia/Singapore</option>
          <option value="Pacific/Auckland">Pacific/Auckland</option>
          <option value="Africa/Johannesburg">Africa/Johannesburg</option>
          <option value="Asia/Kolkata">Asia/Kolkata</option>
          <!-- Add more time zones as needed -->
      </select>
    </fieldset>
    <input type="hidden" name="userTimezone" id="userTimezone" value="">
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    <script>
      tinymce.init({
        selector: '#shortCTA',
        plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
          { value: 'First.Name', title: 'First Name' },
          { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
      });
    </script>
    <fieldset>
      <textarea id="shortCTA" name="shortCTA" placeholder="Type in short CTA Here...." tabindex="5"><?php echo $shortCTA; ?></textarea>
    </fieldset>

    <script>
      tinymce.init({
        selector: '#longCta',
        plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
          { value: 'First.Name', title: 'First Name' },
          { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
      });
    </script>
    <fieldset>
      <textarea id="longCta" name="longCTA" placeholder="Type in long CTA Here...." tabindex="5" rows="8"><?php echo $longCTA; ?></textarea>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending" value="Schedule/Update" onclick="captureTimezone()">Submit</button>
    </fieldset>
  </form>
 
  
</div>
<!-- partial -->
  
</body>
</html>
