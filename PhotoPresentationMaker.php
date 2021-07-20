<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Stylesheet script link-->
    <link rel="stylesheet" href="PPM_Style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="http://code.jquery.com/ui/1.8.24/themes/blitzer/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.css" integrity="sha512-NCJ1O5tCMq4DK670CblvRiob3bb5PAxJ7MALAz2cV40T9RgNMrJSAwJKy0oz20Wu7TDn9Z2WnveirOeHmpaIlA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Photo Presentation Maker</title>
</head>

<body style="background-image: url(background_fyp.jpg); background-size: 100% 105%;">
    <div class="grid-container">
        <!--Menu container-->
        <div class="menu" id="menu">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="image" id="lImage">Select images to upload:</label>
                <br>
                <!--Image limit resource: https://stackoverflow.com/questions/4328947/limit-file-format-when-using-input-type-file -->
                <input type="file" id="file" name="files[]" multiple accept="image/*">
                <br>
                <input type="submit" name="submit" id="submit" value="Upload Images">
            </form>

            <!--PHP code to retrieve image from the server-->
            <?php
            include 'PPM_dbConfig.php';

            try {
                // Connection to the MAMP server
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

                // Attribute to connect server by PDO connection
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare read all query to retrieve the data that store in the server
                $sql = $conn->prepare("SELECT * FROM `images`");
                $sql->execute(); // Execute the query
                $image_array = $sql->fetchAll(); // Retrieve multiple image from the server

                // Display image by using foor loop
                foreach ($image_array as $image) {

                    echo "<img class ='photo' id='" . $image['image_id'] . "' src='" . $image['image_name'] . "' onclick='display(this)'>";
                }
            } catch (PDOEXCEPTION $e) {
                // Exception catching
                echo "<br>" . $e->getMessage();
            }
            ?>
        </div>

        <!--Header container-->
        <div class="header" id="header">
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            <button onclick="openFullscreen();" id="fullscreen"><i class="fas fa-expand"></i></button>
            <button onclick="pauseSlide();" id="pause"><i class="fas fa-pause"></i></button>
            <button onclick="playSlide();" id="play"><i class="fas fa-play"></i></button>
        </div>

        <!--Content container-->
        <div class="content" id="mySlide">
            <img class="img" id="previewImg" src="" alt="Drag your image below the transition label" />
        </div>

        <!--Footer container-->
        <div class="footer" id="footer">
            <div class="column" id="transition_select">
                <label id="transition_title">Transition:</label>
                <select name="transition" id="transition">
                    <option value="empty">---Please Select---</option>
                    <option value="slideIn">Slide</option>
                    <option value="fadeIn">Fade</option>
                </select>
            </div>

            <!--Arrange container-->
            <div id="arrange" class="arrange">
            </div>
        </div>
    </div>

    <!--JavaScript script links-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.8.24/jquery-ui.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js" integrity="sha512-FHa4dxvEkSR0LOFH/iFH0iSqlYHf/iTwLc5Ws/1Su1W90X0qnxFxciJimoue/zyOA/+Qz/XQmmKqjbubAAzpkA==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="PPM_Functions.js"></script>
</body>

</html>