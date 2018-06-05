<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    // // $email = $_POST["email"];
    // // $password = $_POST["password"];
    // // $name = $_POST["name"];
    // // $sex = $_POST["sex"];
    // $birth_month = $_POST["birth_month"];
    // $birth_date = $_POST["birth_date"];
    // $birth_status = 1;
    // $emotional_status = emotional_to_index($_POST["emotional_status"]);
    // // $major = major_to_index($_POST["major"]);
    // $club = $_POST["club"];
    // $hobby = $_POST["hobby"];
    // $favorite_class = $_POST["favorite_class"];
    // $favorite_city = $_POST["favorite_city"];
    // $confusion = $_POST["confusion"];
    // $talent = $_POST["talent"];
    // $dream = $_POST["dream"];
    // // $image = $_POST["image"];

    $userID = 4;
    $token = "4078497";
    // $email = "401401087@mail.fju.edu.tw";
    // $password = "0534";
    // $name = "柯唯揚";
    // $sex = 1;
    $birth_month = 8;
    $birth_date = 6;
    $birth_status = 1;
    $emotional_status = emotional_to_index("一言難盡");
    // $major = major_to_index("資訊管理學系");
    $club = "魔術社";
    $hobby = "躺著";
    $favorite_class = "下課";
    $favorite_city = "泰山";
    $confusion = "睡不飽";
    $talent = "好像也沒有";
    $dream = "沒想過";
    // $image = "mars.jpg";

    function searchUser() {
        global $con, $userID, $token;
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE userid = ? AND token = ?");
        mysqli_stmt_bind_param($statement, "is", $userID, $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateInfo() {
        global $con, $userID, $token, $birth_month, $birth_date, $birth_status,
        $emotional_status, $club, $hobby, $favorite_class, $favorite_city, $confusion, $talent, $dream;
        $statement = mysqli_prepare($con, "UPDATE user SET birth_month = ?,
          birth_date = ?, birth_status = ?, emotional_status = ?, club = ?, hobby = ?, favorite_class = ?,
          favorite_city = ?, confusion = ?, talent = ?, dream = ? WHERE userid = ? AND token = ?");
        mysqli_stmt_bind_param($statement, "iiiisssssssss", $birth_month, $birth_date, $birth_status,
         $emotional_status, $club, $hobby, $favorite_class, $favorite_city, $confusion, $talent, $dream, $userID, $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    $response = array();
    $response["success"] = false;

    if (searchUser()) {
        updateInfo();
        $response["success"] = true;
    } else {
        // echo "Not found the USER!";
        $response["error"] = "notFoundUser";
    }

    echo urldecode(json_encode($response));
?>
