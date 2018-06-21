<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    $userID = 3;
    $token = "1296537";

    function searchUser() {
        global $con, $userID, $token;
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE userid = ? AND token = ?");
        mysqli_stmt_bind_param($statement, "ss", $userID, $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function userInfo() {
        global $con, $userID, $token, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE userid = ? AND token = ?");
        mysqli_stmt_bind_param($statement, "ss", $userID, $token);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colUserID, $colToken, $colEmail, $colPassword, $colName,
        $colSex, $colBirthMonth, $colBirthDate, $colBirthStatus, $colEmotionalStatus, $colMajor, $colClub, $colHobby,
        $colFavorClass, $colFavorCity, $colConfusion, $colTalent, $colDream, $colImage, $colPairLordStatus, $colPairAngelStatus);

        while (mysqli_stmt_fetch($statement)) {
            // $response["userid"] = $colUserID;
            // $response["token"] = $colToken;
            // $response["email"] = $colEmail;
            // $response["password"] = $colPassword;
            // $response["name"] = urlencode($colName);
            // $response["sex"] = $colSex;
            // $response["birth_month"] = $colBirthMonth;
            // $response["birth_date"] = $colBirthDate;
            // $response["birth_status"] = $colBirthStatus;
            // $response["emotional_status"] = $colEmotionalStatus;
            // $response["major"] = $colMajor;
            // $response["club"] = urlencode($colClub);
            // $response["hobby"] = urlencode($colHobby);
            // $response["favorite_class"] = urlencode($colFavorClass);
            // $response["favorite_city"] = urlencode($colFavorCity);
            // $response["confusion"] = urlencode($colConfusion);
            // $response["talent"] = urlencode($colTalent);
            // $response["dream"] = urlencode($colDream);
            $response["image"] = "http://140.136.133.78/angel_pair/imgg/".$colImage;
            // $response["pair_lord_status"] = $colPairLordStatus;
            // $response["pair_angel_status"] = $colPairAngelStatus;
        }
    }

    $response = array();
    $response["success"] = false;

    if (searchUser()) {
        userInfo();
        $response["success"] = true;
    } else {
        // echo "Not found the USER!";
        $response["error"] = "notFoundUser";
    }

    echo urldecode(json_encode($response));
?>
