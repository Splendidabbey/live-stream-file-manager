<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

$viewerUserTimezone = $_GET['userTimezone'] ? $_GET['userTimezone'] : "";
$userTimezone = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'] ? $_GET['id'] : "";
    $queryResult = queryVideoByIdAfterWatch($mysqli, $id);

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
            $thirdCTA = $row['thirdCTA'];
            $shortCTA_BTN = $row['shortCTA_BTN'];
            $longCTA_BTN = $row['longCTA_BTN'];
            $thirdCTA_BTN = $row['thirdCTA_BTN'];
            $CTA_video = $row['CTA_video'];
        }
    }
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One OneWebinar - <?php echo $videoName; ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Light gray background */
            color: #333; /* Dark text color */
        }

        /* Style for the Registration Form */
.registration-form-container {
  text-align: center;
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.registration-form-container h2 {
  font-size: 24px;
  color: #333;
  margin-bottom: 20px;
}

.registration-form-container label {
  display: block;
  text-align: left;
  margin-top: 10px;
}

        .registration-form-container input {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        }

        .registration-form-container button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }

        header,
        section,
        footer {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff; /* White background */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); /* Slightly darker shadow */
            margin-top: 20px; /* Spacing from the top */
        }

        header h1 {
            font-size: 2.5em;
            color: #e74c3c; /* Red color */
        }

        section p {
            font-size: 1.2em;
            color: #777; /* Dark gray text color */
        }

        .cta-section {
            text-align: center;
            margin-top: 20px;
        }

        .cta-button {
            padding: 15px 30px;
            font-size: 1.2em;
            background-color: #3498db; /* Blue color */
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 8px; /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth color transition */
        }

        .cta-button:hover {
            background-color: #2c3e50; /* Slightly darker blue on hover */
        }

        #video {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 25px;
            height: 0;
            margin-top: 20px; /* Spacing from the top */
        }

        #video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 15px; /* Rounded corners for the video container */
        }

        footer {
            text-align: center;
            margin-top: 20px; /* Spacing from the top */
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <h1 style="color: #e74c3c;"><?php echo $videoName; ?></h1>
        <!-- <p style="color: #777;">Discover the [Key Benefits] that will transform your [Specific Outcome].</p> -->
    </header>
    

    <!-- Video Section -->
    <section id="video">
        <div class="video-container">
            <!-- Replace 'your-video-url' with the actual URL of your video -->
            <iframe width="auto" height="100%" src="https://www.youtube.com/embed/<?php echo $CTA_video; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <p style="color: #777;">Watch the video to learn more.</p>
    </section>

    <!-- CTA Section 1 -->
    <section class="cta-section">
        <a href="<?php echo $shortCTA_BTN; ?>">
            <button class="cta-button">Get Started Now</button>
        </a>
        <p style="color: #777;"><?php echo $shortCTA; ?></p>
    </section>

    <!-- CTA Section 2 -->
    <section class="cta-section">
        <a href="<?php echo $longCTA_BTN; ?>">
            <button class="cta-button">Get Started Now</button>
        </a>
        <p style="color: #777;"><?php echo $longCTA; ?></p>
    </section>

    <!-- CTA Section 3 --> 
    <section class="cta-section">
        <a href="<?php echo $thirdCTA_BTN; ?>">
            <button class="cta-button">Get Started Now</button>
        </a>
        <p style="color: #777;"><?php echo $thirdCTA; ?></p>
    </section>

    <script  src="./script.js"></script>
    <script src="./script-new.js"></script>
</body>

</html>
