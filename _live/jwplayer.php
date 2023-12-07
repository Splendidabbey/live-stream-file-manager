<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Html 5 Browser</title>
    <!-- JW Player Script -->
    <script src="http://jwpsrv.com/library/FfMxTl3oEeSEiiIACxmInQ.js"></script>
    <style>
        html,body { height:100%; width:100%; padding:0; margin:0; }
        #mediaplayer { height:100%; width:100%; padding:0; margin:0; }
    </style>
</head>
<body>
    <div id="mediaplayer"></div>
    <iframe src="http://localhost/playtube/embed/4XJ6n9lw2KP1ChG" frameborder="0" width="700" height="400" allowfullscreen></iframe>
    <script>
        jwplayer("mediaplayer").setup({
            file: "vid.mp4",
            width: "100%",
            height: "100%",
            stretching: "bestfit",
            logo: {
                file: "http://localhost/filemanager/live/logo.png", // Replace with the path to your logo image
                hide: false, // Set to true if you want to hide the logo initially
                position: "top-right", // You can set the position of the logo
            },
            displaytitle: false, // Set to false to hide the player title
            controls: false, //
            autostart: true, // Set to true to automatically start playing once the player loads
        });
    </script>
</body>
</html>
