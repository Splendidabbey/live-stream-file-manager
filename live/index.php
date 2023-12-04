<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

// Get the value of the "url" parameter from the query string
$videoURL = null;
$videoName = null;
$liveOn = null;
$userTimezone = null;
$id = null;

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <script>
    document.addEventListener("contextmenu", event => event.preventDefault());
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN link -->
  <title>Livestream Viewer</title>
  <style>
  .video-container .shaka-seek-bar-container {
    display: none;
  }
  </style>
</head>
<body>';

$registrationForm = "
<div class='form-container d-none' id='registration-form'>
<!-- Registration Form -->
<form class='registration-form-container'>
  <h2>Register to join the livestream</h2>
  <label for='name'>Name:</label>
  <input type='text' id='name' name='name' required>
  <label for='country'>Select Country:</label>
  <select class='form-select' aria-label='Default select example' id='countryCode' name='country' required>
    <option value='' disabled selected>Select a country</option>
    <option value='AF'>Afghanistan</option>
    <option value='AL'>Albania</option>
    <option value='DZ'>Algeria</option>
    <option value='AS'>American Samoa</option>
    <option value='AD'>Andorra</option>
    <option value='AO'>Angola</option>
    <option value='AI'>Anguilla</option>
    <option value='AG'>Antigua and Barbuda</option>
    <option value='AR'>Argentina</option>
    <option value='AM'>Armenia</option>
    <option value='AW'>Aruba</option>
    <option value='AU'>Australia</option>
    <option value='AT'>Austria</option>
    <option value='AZ'>Azerbaijan</option>
    <option value='BS'>Bahamas</option>
    <option value='BH'>Bahrain</option>
    <option value='BD'>Bangladesh</option>
    <option value='BB'>Barbados</option>
    <option value='BY'>Belarus</option>
    <option value='BE'>Belgium</option>
    <option value='BZ'>Belize</option>
    <option value='BJ'>Benin</option>
    <option value='BM'>Bermuda</option>
    <option value='BT'>Bhutan</option>
    <option value='BO'>Bolivia</option>
    <option value='BA'>Bosnia and Herzegovina</option>
    <option value='BW'>Botswana</option>
    <option value='BR'>Brazil</option>
    <option value='VG'>British Virgin Islands</option>
    <option value='BN'>Brunei</option>
    <option value='BG'>Bulgaria</option>
    <option value='BF'>Burkina Faso</option>
    <option value='BI'>Burundi</option>
    <option value='KH'>Cambodia</option>
    <option value='CM'>Cameroon</option>
    <option value='CA'>Canada</option>
    <option value='CV'>Cape Verde</option>
    <option value='KY'>Cayman Islands</option>
    <option value='CF'>Central African Republic</option>
    <option value='TD'>Chad</option>
    <option value='CL'>Chile</option>
    <option value='CN'>China</option>
    <option value='CO'>Colombia</option>
    <option value='KM'>Comoros</option>
    <option value='CG'>Congo</option>
    <option value='CK'>Cook Islands</option>
    <option value='CR'>Costa Rica</option>
    <option value='CI'>Côte d'Ivoire</option>
    <option value='HR'>Croatia</option>
    <option value='CU'>Cuba</option>
    <option value='CY'>Cyprus</option>
    <option value='CZ'>Czech Republic</option>
    <option value='DK'>Denmark</option>
    <option value='DJ'>Djibouti</option>
    <option value='DM'>Dominica</option>
    <option value='DO'>Dominican Republic</option>
    <option value='EC'>Ecuador</option>
    <option value='EG'>Egypt</option>
    <option value='SV'>El Salvador</option>
    <option value='GQ'>Equatorial Guinea</option>
    <option value='ER'>Eritrea</option>
    <option value='EE'>Estonia</option>
    <option value='ET'>Ethiopia</option>
    <option value='FK'>Falkland Islands</option>
    <option value='FO'>Faroe Islands</option>
    <option value='FJ'>Fiji</option>
    <option value='FI'>Finland</option>
    <option value='FR'>France</option>
    <option value='GF'>French Guiana</option>
    <option value='PF'>French Polynesia</option>
    <option value='GA'>Gabon</option>
    <option value='GM'>Gambia</option>
    <option value='GE'>Georgia</option>
    <option value='DE'>Germany</option>
    <option value='GH'>Ghana</option>
    <option value='GI'>Gibraltar</option>
    <option value='GR'>Greece</option>
    <option value='GL'>Greenland</option>
    <option value='GD'>Grenada</option>
    <option value='GP'>Guadeloupe</option>
    <option value='GU'>Guam</option>
    <option value='GT'>Guatemala</option>
    <option value='GG'>Guernsey</option>
    <option value='GN'>Guinea</option>
    <option value='GW'>Guinea-Bissau</option>
    <option value='GY'>Guyana</option>
    <option value='HT'>Haiti</option>
    <option value='HN'>Honduras</option>
    <option value='HK'>Hong Kong</option>
    <option value='HU'>Hungary</option>
    <option value='IS'>Iceland</option>
    <option value='IN'>India</option>
    <option value='ID'>Indonesia</option>
    <option value='IR'>Iran</option>
    <option value='IQ'>Iraq</option>
    <option value='IE'>Ireland</option>
    <option value='IM'>Isle of Man</option>
    <option value='IL'>Israel</option>
    <option value='IT'>Italy</option>
    <option value='JM'>Jamaica</option>
    <option value='JP'>Japan</option>
    <option value='JE'>Jersey</option>
    <option value='JO'>Jordan</option>
    <option value='KZ'>Kazakhstan</option>
    <option value='KE'>Kenya</option>
    <option value='KI'>Kiribati</option>
    <option value='KW'>Kuwait</option>
    <option value='KG'>Kyrgyzstan</option>
    <option value='LA'>Laos</option>
    <option value='LV'>Latvia</option>
    <option value='LB'>Lebanon</option>
    <option value='LS'>Lesotho</option>
    <option value='LR'>Liberia</option>
    <option value='LY'>Libya</option>
    <option value='LI'>Liechtenstein</option>
    <option value='LT'>Lithuania</option>
    <option value='LU'>Luxembourg</option>
    <option value='MK'>Macedonia</option>
    <option value='MG'>Madagascar</option>
    <option value='MW'>Malawi</option>
    <option value='MY'>Malaysia</option>
    <option value='MV'>Maldives</option>
    <option value='ML'>Mali</option>
    <option value='MT'>Malta</option>
    <option value='MH'>Marshall Islands</option>
    <option value='MQ'>Martinique</option>
    <option value='MR'>Mauritania</option>
    <option value='MU'>Mauritius</option>
    <option value='YT'>Mayotte</option>
    <option value='MX'>Mexico</option>
    <option value='FM'>Micronesia</option>
    <option value='MD'>Moldova</option>
    <option value='MC'>Monaco</option>
    <option value='MN'>Mongolia</option>
    <option value='ME'>Montenegro</option>
    <option value='MS'>Montserrat</option>
    <option value='MA'>Morocco</option>
    <option value='MZ'>Mozambique</option>
    <option value='MM'>Myanmar</option>
    <option value='NA'>Namibia</option>
    <option value='NR'>Nauru</option>
    <option value='NP'>Nepal</option>
    <option value='NL'>Netherlands</option>
    <option value='AN'>Netherlands Antilles</option>
    <option value='NC'>New Caledonia</option>
    <option value='NZ'>New Zealand</option>
    <option value='NI'>Nicaragua</option>
    <option value='NE'>Niger</option>
    <option value='NG'>Nigeria</option>
    <option value='NU'>Niue</option>
    <option value='NF'>Norfolk Island</option>
    <option value='KP'>North Korea</option>
    <option value='MP'>Northern Mariana Islands</option>
    <option value='NO'>Norway</option>
    <option value='OM'>Oman</option>
    <option value='PK'>Pakistan</option>
    <option value='PW'>Palau</option>
    <option value='PS'>Palestine</option>
    <option value='PA'>Panama</option>
    <option value='PG'>Papua New Guinea</option>
    <option value='PY'>Paraguay</option>
    <option value='PE'>Peru</option>
    <option value='PH'>Philippines</option>
    <option value='PN'>Pitcairn Islands</option>
    <option value='PL'>Poland</option>
    <option value='PT'>Portugal</option>
    <option value='PR'>Puerto Rico</option>
    <option value='QA'>Qatar</option>
    <option value='RE'>Réunion</option>
    <option value='RO'>Romania</option>
    <option value='RU'>Russia</option>
    <option value='RW'>Rwanda</option>
    <option value='SH'>Saint Helena</option>
    <option value='KN'>Saint Kitts and Nevis</option>
    <option value='LC'>Saint Lucia</option>
    <option value='PM'>Saint Pierre and Miquelon</option>
    <option value='VC'>Saint Vincent and the Grenadines</option>
    <option value='WS'>Samoa</option>
    <option value='SM'>San Marino</option>
    <option value='ST'>São Tomé and Príncipe</option>
    <option value='SA'>Saudi Arabia</option>
    <option value='SN'>Senegal</option>
    <option value='RS'>Serbia</option>
    <option value='SC'>Seychelles</option>
    <option value='SL'>Sierra Leone</option>
    <option value='SG'>Singapore</option>
    <option value='SK'>Slovakia</option>
    <option value='SI'>Slovenia</option>
    <option value='SB'>Solomon Islands</option>
    <option value='SO'>Somalia</option>
    <option value='ZA'>South Africa</option>
    <option value='GS'>South Georgia</option>
    <option value='KR'>South Korea</option>
    <option value='ES'>Spain</option>
    <option value='LK'>Sri Lanka</option>
    <option value='SD'>Sudan</option>
    <option value='SR'>Suriname</option>
    <option value='SJ'>Svalbard and Jan Mayen</option>
    <option value='SZ'>Swaziland</option>
    <option value='SE'>Sweden</option>
    <option value='CH'>Switzerland</option>
    <option value='SY'>Syria</option>
    <option value='TW'>Taiwan</option>
    <option value='TJ'>Tajikistan</option>
    <option value='TZ'>Tanzania</option>
    <option value='TH'>Thailand</option>
    <option value='TG'>Togo</option>
    <option value='TK'>Tokelau</option>
    <option value='TO'>Tonga</option>
    <option value='TT'>Trinidad and Tobago</option>
    <option value='TN'>Tunisia</option>
    <option value='TR'>Turkey</option>
    <option value='TM'>Turkmenistan</option>
    <option value='TC'>Turks and Caicos Islands</option>
    <option value='TV'>Tuvalu</option>
    <option value='UG'>Uganda</option>
    <option value='UA'>Ukraine</option>
    <option value='AE'>United Arab Emirates</option>
    <option value='GB'>United Kingdom</option>
    <option value='US'>United States</option>
    <option value='UY'>Uruguay</option>
    <option value='UM'>U.S. Minor Outlying Islands</option>
    <option value='VI'>U.S. Virgin Islands</option>
    <option value='UZ'>Uzbekistan</option>
    <option value='VU'>Vanuatu</option>
    <option value='VA'>Vatican City</option>
    <option value='VE'>Venezuela</option>
    <option value='VN'>Vietnam</option>
    <option value='WF'>Wallis and Futuna</option>
    <option value='EH'>Western Sahara</option>
    <option value='YE'>Yemen</option>
    <option value='ZM'>Zambia</option>
    <option value='ZW'>Zimbabwe</option>
  </select>
  <label for='phoneNumber'>Phone number:</label>
  <input type='text' id='phoneNumber' name='phoneNumber' required>
  <label for='email'>Email:</label>
  <input type='email' id='email' name='email' required>
  <button type='submit'>Register</button>
</form>
</div>
"
;

$content = '
  <div class="info-container">
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
  <a href="https://wa.me/97470926454" target="_blank" class="cta-button">
    Click here, to send Proof Of Payment👇
  </a>
  <br><br>
  </div>
  </body>
  </html>
';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
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
$viewerUserTimezone = $_GET['userTimezone'] ? $_GET['userTimezone'] : "";

$newContent = '
<div class="info-container">
  <h1>Unforntunately this webinar has ended.</h1>
  <p class="webinar-p">Please click the button below to send the host an inquiry on when the next will hold.</p>
  <a href="https://wa.me/97470926454" target="_blank" class="cta-button">
  Click here👇
</a><br><br>
</div>
';

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
        echo $registrationForm;
        echo '
        <div style="display:none;" class="video-container">
        <div class="container">
          <div class="row">
            <div class="col-md-9 livestream-container">
              <div class="video-container">
                <div class="video-wrapper" style="height: 100%;">';
    
        // Output the video element with Shaka Player
        echo '
        <div class="youtube-container">
          <!-- Placeholder for the YouTube player -->
          <div id="player"></div>

          <!-- Transparent overlay to capture clicks -->
          <div class="overlay"></div>
        </div>';
        
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
        </div>';

        echo '<script src="https://www.youtube.com/iframe_api"></script>';
        echo '<script src="js/script.js"></script>';
        echo '
        <script>
        var player;

// Create a YouTube player
function onYouTubeIframeAPIReady() {
  player = new YT.Player("player", {
    height: "360",
    width: "640",
    videoId: "H69g7NB8EeQ", // Replace with your actual video ID
    playerVars: {
      "autoplay": 0,        // Do not autoplay initially
      "controls": 0,        // Hide video controls
      "showinfo": 0,        // Hide video information
      "rel": 0,             // Do not show related videos
      "modestbranding": 1,  // Remove YouTube logo
      "playsinline": 1,     // Play the video inline on mobile devices
      "disablekb": 1        // Disable keyboard controls, including "Watch later" and "Share"
    }
  });

  // Add click event listener to the play button
  var playButton = document.getElementById("play-button");
  playButton.addEventListener("click", function() {
    player.playVideo();
  });
}

        </script>
        ';
        echo '
        </body>
        </html>';
      } else {
        echo $newContent;
        if(hasBeenScheduleBydId($mysqli, $id)) {
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
    echo $newContent;
    echo ' 
    </body>
    </html>';
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['end'])) {
  echo $content;
}
?>
