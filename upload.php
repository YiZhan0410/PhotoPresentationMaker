<?php
// Include MAMP server connection from PPM_dbConfig.php file.
include 'PPM_dbConfig.php';

   if (isset($_POST['submit'])){
       // File upload configuration
       $targetDir = "uploads/";

       // Only allow jpg, png, jpeg and gif format files only.
       $allowTypes = array('jpg','png','jpeg','gif');
       
       $statusMsg = '';
   
       if(!empty(array_filter($_FILES['files']['name']))){
           
           //Loop through all of the files you selected to upload
           foreach($_FILES['files']['name'] as $key=>$val){
               // File upload path
               $fileName = basename($_FILES['files']['name'][$key]);
               
               $targetFilePath = $targetDir . $fileName;
               
               // Check whether file type is valid by looking at the file extension
               $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
               if(in_array($fileType, $allowTypes)){
                   // Upload file to server
                   if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                       
                   //insert the filename into the SQL table product_images
                   $sql = "INSERT INTO images (image_name) values ('$fileName')";

                   try {
                       $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                       // set the PDO error mode to exception
                       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       
                       //we use the last inserted ID from the product table and the target filepath to record where the image will live
                       $sql = "INSERT INTO images (image_id, image_name) VALUES (0, '$targetFilePath')"; // building a string with the SQL INSERT you want to run
                       
                       // use exec() because no results are returned
                       $conn->exec($sql);
                       $statusMsg = "Images added";
                       header("Location:/PhotoPresentationMaker/PhotoPresentationMaker.php");

                       }
                   catch(PDOException $e)
                       {
                       echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
                       }
   
                   }else{
                       //for some reason the file may have not uploaded, such as a dropped connection
                       $errorUpload .= "Upload error:". $_FILES['files']['name'][$key].', ';
                       echo $errorUpload;
                   }
               }else{
                   //Wrong file type
                   $errorUploadType .= "Wrong file type". $_FILES['files']['name'][$key].', ';
                   echo $errorUploadType;
               }
           }
           
           
       }else{
           $statusMsg = 'Please select a file to upload.';
       }
       
       // Display status message
       echo $statusMsg;
   }
?>