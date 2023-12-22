<?php
session_start(); // Start the PHP session

// Check if the user is authenticated
if (!isset($_SESSION['access_token'])) {
    // Redirect to the authentication page
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Generated Photo Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .gallery {
            max-width: 100%;
            margin: 20px auto;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            max-height:750px;
        }
        .btn {
            padding: 10px 20px;
            margin: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #555;
        }
        @media screen and (max-width: 600px) {
            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="gallery">
        <img id="photo" src="img1.png" alt="Vision">
        <br>
        <button class="btn" onclick="changeImage(-1)">Previous</button>
        <button class="btn" onclick="changeImage(1)">Next</button>
    </div>

    <script>
        // Array of image paths
        var images = [
            "img1.png",
            "img2.png",
            "img3.png",
            // Add as many images as you like
        ];
        var currentIndex = 0;

        function changeImage(direction) {
            currentIndex += direction;
            if (currentIndex < 0) {
                currentIndex = images.length - 1;
            } else if (currentIndex > images.length - 1) {
                currentIndex = 0;
            }
            document.getElementById("photo").src = images[currentIndex];
        }
    </script>
</body>
</html>
