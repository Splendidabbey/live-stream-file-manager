<?php
require_once('includes/function.php');
require_once('includes/conndb.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    echo "hello";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Product/Service Landing Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; /* Light gray background */
            color: #333; /* Dark text color */
        }

        header, section, footer {
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

        /* Add additional styling for other sections, as needed */

    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <h1 style="color: #e74c3c;">Unlock Your Success with [Your Product/Service]</h1>
        <!-- <p style="color: #777;">Discover the [Key Benefits] that will transform your [Specific Outcome].</p> -->
    </header>

    <!-- Video Section -->
    <section id="video">
        <div class="video-container">
            <!-- Replace 'your-video-url' with the actual URL of your video -->
            <iframe width="auto" height="100%" src="" frameborder="0" allowfullscreen></iframe>
        </div>
        <p style="color: #777;">Watch the video to learn more.</p>
    </section>

    <!-- CTA Section 1 -->
    <section class="cta-section">
        <button class="cta-button">Get Started Now</button>
        <p style="color: #777;">Take the first step towards [specific benefit]. Click the button below to get started on your journey to success!</p>
    </section>

    <!-- CTA Section 2 -->
    <section class="cta-section">
        <button class="cta-button">Explore Our Packages</button>
        <p style="color: #777;">Discover the perfect plan for your needs. Click below to explore our packages and find the one that fits you best!</p>
    </section>

    <!-- CTA Section 3 -->
    <section class="cta-section">
        <button class="cta-button">See Results for Yourself</button>
        <p style="color: #777;">Curious about the results our customers have achieved? Click below to see real-life success stories and testimonials.</p>
    </section>

</body>

</html>