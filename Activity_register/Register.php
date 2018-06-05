<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $email = $_POST["email"];
    // $password = $_POST["password"];
    // $name = $_POST["name"];
    // $sex = $_POST["sex"];
    // $birth_status = 0;
    // $major = major_to_index($_POST["major"]);

    $email = "Abby000@gmail.com";
    $password = "09876";
    $name = "Abby";
    $sex = 0;
    $birth_status = 0;
    $major = major_to_index("會計學系");

    $club = "未填";
    $hobby = "未填";
    $favorite_class = "未填";
    $favorite_city = "未填";
    $confusion = "未填";
    $talent = "未填";
    $dream = "未填";
    $image = "profile.png";

    $token = substr($email, 0, 2).rand(10000, 99999); //email前四碼+亂數四碼

    function registerUser() {
        global $con, $token, $email, $password, $name, $sex, $birth_status, $major, $club, $hobby, $favorite_class, $favorite_city, $confusion, $talent, $dream, $image;
        // $passwordHash = password_hash($password, PASSWORD_DEFAULT); //使用hash值存入資料庫
        $statement = mysqli_prepare($con, "INSERT INTO user (token, email, password, name, sex, birth_status, major, club, hobby, favorite_class, favorite_city, confusion, talent, dream, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "ssssiiissssssss", $token, $email, $password, $name, $sex, $birth_status, $major, $club, $hobby, $favorite_class, $favorite_city, $confusion, $talent, $dream, $image);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    function emailAvailable() {
        global $con, $email;
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE email = ?");
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        mysqli_stmt_close($statement);
        if ($count < 1){
            return true;
        } else {
            return false;
        }
    }

    function getUserID() {
        global $con, $token, $response;
        $statement = mysqli_prepare($con, "SELECT userid FROM user WHERE token = ?");
        mysqli_stmt_bind_param($statement, "s", $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colUserID);

        while (mysqli_stmt_fetch($statement)) {
            $response["userid"] = $colUserID;
            $response["token"] = $token;
        }
    }

    $response = array();
    $response["success"] = false;

    if (emailAvailable()) {
        registerUser();
        getUserID();
        $response["success"] = true;
    } else {
        // echo "Email is registered!";
        $response["error"] = "emailUsed";
    }

    echo json_encode($response);
?>
