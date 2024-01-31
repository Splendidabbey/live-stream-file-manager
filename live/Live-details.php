<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'] ? $_GET['id'] : "";
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
            $id = $row['id'];
            $thirdCTA = $row['thirdCTA'];
            $shortCTA_BTN = $row['shortCTA_BTN'];
            $longCTA_BTN = $row['longCTA_BTN'];
            $thirdCTA_BTN = $row['thirdCTA_BTN'];
            $CTA_video = $row['CTA_video'];
        }
    }
}
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
            <iframe width="auto" height="100%" src="https://www.youtube.com/embed/<?php echo $videoURL; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
</body>

</html>
