<?php
    // require("password.php");
    include("../major_trans.php");
    include("../Activity_image/DownloadImg.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    $userID = 3;
    $token = "";

    function pairStatus() {
        global $con, $userID, $response; //設定全域變數
        $statement = mysqli_prepare($con, "SELECT pair_lord_status FROM user WHERE userid = ?"); //設定要執行的SQL指令，以?代表參數
        mysqli_stmt_bind_param($statement, "i", $userID); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_store_result($statement); //將結果回傳並儲存
        mysqli_stmt_bind_result($statement, $colPairLordStatus);
        while (mysqli_stmt_fetch($statement)) {
            $response["pair_lord_status"] = $colPairLordStatus;
        }
    }

    function getPairInfo() {
        global $con, $userID, $response; //設定全域變數
        $statement = mysqli_prepare($con, "SELECT * FROM pair, user WHERE pair.lord = ? AND user.userid = pair.angel AND pair.status = 0"); //設定要執行的SQL指令，以?代表參數
        mysqli_stmt_bind_param($statement, "i", $userID); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_store_result($statement); //將結果回傳並儲存
        mysqli_stmt_bind_result($statement, $colUserID_P, $colPair, $colStatus, $colUserID_U, $colToken, $colEmail, $colPassword, $colName,
        $colSex, $colBirthMonth, $colBirthDate, $colBirthStatus, $colEmotionalStatus, $colMajor, $colClub, $colHobby,
        $colFavorClass, $colFavorCity, $colConfusion, $colTalent, $colDream, $colImage, $colPairLordStatus, $colPairAngelStatus); //回傳結果與變數連結
        $count = mysqli_stmt_num_rows($statement); //回傳列數
        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                $response["userid"] = $colUserID_U;
                // $response["token"] = $colToken;
                // $response["email"] = $colEmail;
                // $response["password"] = $colPassword;
                $response["name"] = urlencode($colName);
                $response["sex"] = $colSex;
                $response["birth_month"] = $colBirthMonth;
                $response["birth_date"] = $colBirthDate;
                // $response["birth_status"] = $colBirthStatus;
                $response["emotional_status"] = urlencode(index_to_emotional($colEmotionalStatus));
                $response["major"] = urlencode(index_to_major($colMajor));
                $response["club"] = urlencode($colClub);
                $response["hobby"] = urlencode($colHobby);
                $response["favorite_class"] = urlencode($colFavorClass);
                $response["favorite_city"] = urlencode($colFavorCity);
                $response["confusion"] = urlencode($colConfusion);
                $response["talent"] = urlencode($colTalent);
                $response["dream"] = urlencode($colDream);
                $response["image"] = urlencode(img_to_base64($colImage));
            }
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    pairStatus();
    if (getPairInfo()) {
        $response["success"] = true;
    } else {
        // echo "Get pair failed!";
        $response["error"] = "getFailed";
    }

    echo urldecode(json_encode($response));
?>
