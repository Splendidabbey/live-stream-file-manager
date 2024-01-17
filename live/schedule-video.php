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

    select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
            width: 250px;
            outline: none;
            cursor: pointer;
        }

        select:hover {
            border-color: #3498db;
        }

        option {
            background-color: #fff;
            color: #333;
        }

        option:hover {
            background-color: #3498db;
            color: #fff;
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

    input[type="datetime-local"] {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 10px;
        width: 200px;
        outline: none;
    }

    input[type="datetime-local"]:focus {
        border-color: #3498db;
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

    #copyButton {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 10px;
            border: 1px solid #3498db;
            border-radius: 5px;
            background-color: #3498db;
            color: #fff;
        }

        #copyButton:hover {
            background-color: #2980b9;
        }

        #copyIcon {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        #copyMessage, #copyMessageLong, #copyMessageThird {
            display: none;
            color: #27ae60;
            margin-left: 10px;
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
      <b><label for="timezone">Select Time Zone:</label></b>
      <select id="timezone" name="userTimezone">
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
      </select><br>
      <b><label>Select Live Date</label></b>
      <input name="liveOn" type="date" name="liveOn"><br>
      <b><label>Start Time</label></b>
      <input name="liveOn" type="time" name="liveOn">
      <b><label>End Time</label></b>
      <input name="liveOn" type="time" name="liveOn"><br>
      <b><label>Frequency</label></b>
      <select name="" id="">
        <option value="">One Time</option>
        <option value="">Daily</option>
        <option>Weekly</option>
        <option value="">Monthly</option>
        <option value="">Yearly</option>
      </select>
    </fieldset>
    <input type="hidden" name="" id="userTimezone" value="">
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
    <div id="copyButton" onclick="copyText()">
        <svg id="copyIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M9 1V9H1"></path>
        </svg>
        Copy CTA 1
        <span id="copyMessage">Copied!</span>
    </div>
    <fieldset>
      <textarea id="shortCTA" name="shortCTA" placeholder="Type in CTA 1 Here...." tabindex="5"><?php echo $shortCTA; ?></textarea>
    </fieldset>
    <input name="cta1Link" type="text" placeholder="type in CTA 1 button link">
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
    <div id="copyButton" onclick="copyTextLong()">
        <svg id="copyIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M9 1V9H1"></path>
        </svg>
        Copy CTA 2
        <span id="copyMessageLong">Copied!</span>
    </div>
    <fieldset>
      <textarea id="longCta" name="longCTA" placeholder="Type in CTA 2 Here...." tabindex="5" rows="8"><?php echo $longCTA; ?></textarea>
    </fieldset>
    <input name="cta2Link" type="text" placeholder="type in CTA 2 button link">
    <script>
      tinymce.init({
        selector: '#thirdCta',
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
    <div id="copyButton" onclick="copyTextThird()">
        <svg id="copyIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M9 1V9H1"></path>
        </svg>
        Copy CTA 3
        <span id="copyMessageThird">Copied!</span>
    </div>
    <fieldset>
      <textarea id="thirdCta" name="longCTA" placeholder="Type in CTA 2 Here...." tabindex="5" rows="8"><?php echo $longCTA; ?></textarea>
    </fieldset>
    <input name="cta3Link" type="text" placeholder="type in CTA 3 button link">
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending" value="Schedule/Update" onclick="captureTimezone()">Submit</button>
    </fieldset>
  </form>
 
  
</div>
<!-- partial -->
  <script>
     function copyText() {
            const textToCopy = document.getElementById('shortCTA').value; // Replace with your desired text
            navigator.clipboard.writeText(textToCopy).then(function() {
                showCopyMessage();
            }).catch(function(err) {
                console.error('Unable to copy text', err);
            });
        }

      function showCopyMessage() {
          const copyMessage = document.getElementById('copyMessage');
          copyMessage.style.display = 'inline-block';

          setTimeout(function() {
              copyMessage.style.display = 'none';
          }, 1500); // Display "Copied!" message for 1.5 seconds
      }

      function copyTextLong() {
            const textToCopy = document.getElementById('longCta').value; // Replace with your desired text
            navigator.clipboard.writeText(textToCopy).then(function() {
                showCopyMessageLong();
            }).catch(function(err) {
                console.error('Unable to copy text', err);
            });
        }

      function showCopyMessageLong() {
          const copyMessage = document.getElementById('copyMessageLong');
          copyMessage.style.display = 'inline-block';

          setTimeout(function() {
              copyMessage.style.display = 'none';
          }, 1500); // Display "Copied!" message for 1.5 seconds
      }

      function copyTextThird() {
            const textToCopy = document.getElementById('thirdCta').value; // Replace with your desired text
            navigator.clipboard.writeText(textToCopy).then(function() {
                showCopyMessageThird();
            }).catch(function(err) {
                console.error('Unable to copy text', err);
            });
        }

      function showCopyMessageThird() {
          const copyMessage = document.getElementById('copyMessageThird');
          copyMessage.style.display = 'inline-block';

          setTimeout(function() {
              copyMessage.style.display = 'none';
          }, 1500); // Display "Copied!" message for 1.5 seconds
      }
  </script>
</body>
</html>
