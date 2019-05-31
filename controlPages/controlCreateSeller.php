<?php

if (!file_exists("../seller/".$s_key)) {
    mkdir("../seller/".$s_key, 0777, true);
}

$newFileName = "../seller/".$s_key."/"."index.php";
$newFileContent = '<?php require("../.././templatePages/mainPages/sellerStore.php"); ?>';


if (file_put_contents($newFileName, $newFileContent) !== false) {} else {}

$addUser=mysqli_query($connect_db,
"INSERT INTO seller (s_email, s_password, s_key, s_name)
VALUES('".$s_email."','".$s_password."','".$s_key."','".$s_name."')");

 ?>
