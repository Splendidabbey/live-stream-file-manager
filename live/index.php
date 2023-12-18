<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

// Get the value of the "url" parameter from the query string
$videoURL = null;
$videoName = null;
$liveOn = null;
$userTimezone = null;
$id = null;

echo'
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Onewebinar- Live video</title>
  <link rel="stylesheet" href="./style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN link -->
</head>
<body>';

$registrationForm = "
<div class='form-container' id='registration-form'>
<!-- Registration Form -->
<form id='form-field' onsubmit='event.preventDefault();' class='registration-form-container'>
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
  <button id='register-submit' type='submit'>Register</button>
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
        $shortCTA = $row['shortCTA'];
        $longCTA = $row['longCTA'];
    }
    if(isLiveOn($liveOn, $userTimezone) == true) {
      echo $registrationForm;
      echo '
<link href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,700&display=swap" rel="stylesheet"> 
<div hidden id="app-container" class="app-container">
  <div id="scrolling-container">
    <div class="scrolling-content" id="content1"></div>
    <div class="scrolling-content" id="content2"></div>
  </div>
   <button class="mode-switch">
       <svg class="sun" fill="none" stroke="#fbb046" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-sun" viewBox="0 0 24 24"><defs/><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
  <svg class="moon" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-moon" viewBox="0 0 24 24"><defs/><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
     </button>
   <div class="left-side">
     <div class="navigation">
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home" viewBox="0 0 24 24">
           <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
           <path d="M9 22V12h6v10"/>
         </svg>
       </a>
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
           <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
         </svg>
       </a>
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call" viewBox="0 0 24 24">
           <path d="M15.05 5A5 5 0 0119 8.95M15.05 1A9 9 0 0123 8.94m-1 7.98v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
         </svg>
       </a>
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hard-drive">
           <line x1="22" y1="12" x2="2" y2="12"/>
           <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
           <line x1="6" y1="16" x2="6.01" y2="16"/>
           <line x1="10" y1="16" x2="10.01" y2="16"/>
         </svg>
       </a>
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
           <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
           <circle cx="9" cy="7" r="4"/>
           <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
           <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
         </svg>
       </a>
        <a href="#" class="nav-link icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder" viewBox="0 0 24 24">
            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
          </svg>
       </a>
       <a href="#" class="nav-link icon">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings" viewBox="0 0 24 24">
           <circle cx="12" cy="12" r="3"/>
           <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
         </svg>
       </a>
     </div>
   </div>
   <div class="app-main">
   <div class="d-none" id="notification">'. $shortCTA.'</div>
   <div class="video-call-wrapper" id="video-call-wrapper">
      <button id="play-button" class="play-button d-none"><i class="fas fa-play"></i></button>
      <div id="player"></div>
    </div>
     <div class="video-call-actions ">
       <button class="video-action-button mic"></button>
       <button class="video-action-button camera"></button>
       <button class="video-action-button maximize"></button>
       <button id="join-button" class="video-action-button joincall">Join</button>
       <button class="video-action-button magnifier">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zoom-in" viewBox="0 0 24 24">
           <circle cx="11" cy="11" r="8"/>
           <path d="M21 21l-4.35-4.35M11 8v6M8 11h6"/>
         </svg>
         <span>100%</span>
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zoom-out">
             <circle cx="11" cy="11" r="8"/>
             <line x1="21" y1="21" x2="16.65" y2="16.65"/>
             <line x1="8" y1="11" x2="14" y2="11"/>
         </svg>
         </button>
     </div>
   </div>
  <div class="right-side">
    <button class="btn-close-right">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-x-circle" viewBox="0 0 24 24">
        <defs></defs>
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M15 9l-6 6M9 9l6 6"></path>
      </svg>
    </button>
    <div class="chat-container">
      <div class="chat-header">
        <button class="chat-header-button">
         Live Chat
        </button>
      </div>
      <div class="chat-area">
        <div class="message-wrapper reverse">
          <div class="profile-picture">
            <img src="img/apostle.png" alt="pp">
          </div>
          <div class="message-content">
            <p class="name">Admin</p>
            <div class="message">Good morning!🌈</div>
          </div>
        </div>
        <hr><p>Recents Comments</p>
        <div id="comments-list">
          
        </div>
      </div>
      <div class="chat-typing-area-wrapper">
        <div class="chat-typing-area">
          <input id="comment-input" type="text" placeholder="Type your meesage..." class="chat-input">
          <button class="send-button" id="comment-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send" viewBox="0 0 24 24">
              <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div class="participants">
      <div class="participant profile-picture">
        <img src="img/male.png" alt="pp">
      </div>
      <div class="participant profile-picture">
        <img src="img/female.png" alt="pp">
      </div>
      <div class="participant profile-picture">
        <img src="img/male.png" alt="pp">
      </div>
      <div class="participant profile-picture">
        <img src="img/male.png" alt="pp">
      </div>
      <div class="participant-more"><span id="viewer-count">2</span>+</div>
    </div>
  </div>
  <button class="expand-btn">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
    </button>
</div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script  src="./script.js"></script>
  <script src="./script-new.js"></script>

  <script src="https://www.youtube.com/iframe_api"></script>
  <script></script>
  <script>
    var player;

    // Create a YouTube player
    function onYouTubeIframeAPIReady() {
      player = new YT.Player("player", {
        height: "100%",
        width: "100%",
        videoId: "'. $videoURL .'", // Replace with your actual video ID
        playerVars: {
          "autoplay": 1,        // Do not autoplay initially
          "controls": 0,        // Hide video controls
          "showinfo": 0,        // Hide video information
          "rel": 0,             // Do not show related videos
          "modestbranding": 1,  // Remove YouTube logo
          "playsinline": 1,     // Play the video inline on mobile devices
          "disablekb": 1        // Disable keyboard controls, including "Watch later" and "Share"
        },
        events: {
          "onReady": onPlayerReady,
          "onStateChange": onPlayerStateChange
        }
      });

      // Add click event listener to the play button
      var playButton = document.getElementById("play-button");
      const joinButton = document.getElementById("join-button");
      playButton.addEventListener("click", startVideo);
      joinButton.addEventListener("click", startVideo);

      function startVideo() {
        player.playVideo();
        // playButton.style.display = "none";
        joinButton.disabled = true;
      }
      // The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        // You can access the video element here using the event.target
        const videoElement = event.target.getIframe();
        // Add click event listener to the video element to pause the video;
        // videoElement.addEventListener("click", pauseVideo);
      }
      
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
          // Set an interval to check the video progress
          const progressCheckInterval = setInterval(function () {
            const currentTime = player.getCurrentTime();
            const duration = player.getDuration();
            const progress = (currentTime / duration) * 100;
      
            if (progress >= 85) {
              // Remove the "d-none" class from the notification div 
              $("#notification").removeClass("d-none");
            }
            if (progress >= 100) { //100
              var newContent = `<div>'. $longCTA .'</div>`;
              $("#video-call-wrapper").html(newContent);

              // Clear the interval to stop checking the progress
              clearInterval(progressCheckInterval);
            }
          }, 1000); // Check every second
        }
      }
      
    } 
  </script>
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
