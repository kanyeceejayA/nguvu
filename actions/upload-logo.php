<?php
$target_dir = env('target_dir');
// $target_file = $target_dir . basename($_FILES["logo"]["name"]);

    $filename = str_replace(' ', '',$name);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["logo"]['name'],PATHINFO_EXTENSION));
$filename = $filename.'.'.$imageFileType;
$target_file = $target_dir.$filename;

// Check if image logo is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if logo already exists
if (file_exists($target_file)) {
    $rand = rand(100,200);
    $target_file = str_replace('.'.$imageFileType, '-'.$rand.'.'.$imageFileType, $target_file);
    $filename =  str_replace('.'.$imageFileType, '-'.$rand.'.'.$imageFileType, $filename);
    $uploadOk = 1;
}
// Check logo size
if ($_FILES["logo"]["size"] > 1000000) {
    $error = "Sorry, your logo file size is too large.";
    $uploadOk = 0;
}
// Allow certain logo formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = "Sorry, only JPG, JPEG and PNG logos are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $error = "Sorry, your logo was not uploaded.";
// if everything is ok, try to upload logo
} else {
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
        $message = "The logo ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
    } else {
        $error = "Sorry, there was an error uploading your logo.";
    }
}

?>