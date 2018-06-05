<?php

$con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
mysqli_set_charset($con, "utf8"); //中文亂碼

 if (true)
 {
     $userID = $_POST["userid"];
     $token = $_POST["token"];
     $ImageData = $_POST['image_data'];
     $ImageName = $userID."_$token.jpg";
     // $ImagePath = "imgg/$ImageName.jpg";

     $statement = mysqli_prepare($con, "UPDATE user SET image = ? WHERE userid = ? AND token = ?");
     mysqli_stmt_bind_param($statement, "sis", $ImageName, $userID, $token);
     mysqli_stmt_execute($statement);
     mysqli_stmt_close($statement);

     file_put_contents("../imgg/$ImageName", base64_decode($ImageData));

 } else {
    // echo "Please Try Again";
 }

?>
