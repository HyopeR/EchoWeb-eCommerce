<?php
//Upload İmg Control
if (!file_exists(".././seller/".$seller_key."/img")) {
    mkdir(".././seller/".$seller_key."/img", 0777, true);
}

$target_dir = ".././seller/".$seller_key."/img/";
$target_file = $target_dir . basename($_FILES["pro_media"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["pro_media"]["tmp_name"]);
  if($check !== false) {
      $_SESSION['upload_info'] = "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      $_SESSION['upload_info'] = "File is not an image.";
      $uploadOk = 0;
  }
// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['upload_info'] = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["pro_media"]["size"] > 5000000) {
    $_SESSION['upload_info'] = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $_SESSION['upload_info'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION['upload_info'] = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pro_media"]["tmp_name"], $target_file)) {
        $_SESSION['upload_info'] = "The file ". basename( $_FILES["pro_media"]["name"]). " has been uploaded.";

    } else {
        $_SESSION['upload_info'] = "Sorry, there was an error uploading your file.";
    }
}

 ?>
