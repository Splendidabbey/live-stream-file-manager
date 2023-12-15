<?
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
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
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
  <script>
    // JavaScript to capture the users timezone and add it to the form
    function captureTimezone() {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById("userTimezone").value = timezone;
    }
  </script>
  <script>
    document.addEventListener("contextmenu", event => event.preventDefault());
  </script>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">  
  <form id="contact" action="includes/schedule-video.php" method="post">
    <h3>Upload Your videos</h3>
    <h4>fill in all necessary fields</h4>
    <fieldset>
      <input name="videoName" placeholder="video name" type="text" tabindex="1" required autofocus>
    </fieldset>
    <fieldset>
      <input name="url" placeholder="video url" type="tel" tabindex="3" required>
    </fieldset>
    <fieldset>
      <h2>Select Live date and time</h2>
      <input name="liveOn" type="datetime-local" name="liveOn" required>
    </fieldset>
    <input type="hidden" name="userTimezone" id="userTimezone" value="">
    <fieldset>
      <textarea placeholder="Type in short CTA Here...." tabindex="5"></textarea>
    </fieldset>

    <fieldset>
      <textarea placeholder="Type in long CTA Here...." tabindex="5" rows="8"></textarea>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending" value="Schedule/Update" onclick="captureTimezone()">Submit</button>
    </fieldset>
  </form>
 
  
</div>
<!-- partial -->
  
</body>
</html>
