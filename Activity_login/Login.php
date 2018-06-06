<?php
    // require("password.php");
    include("../major_trans.php");
    include("../Activity_image/DownloadImg.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $email = $_POST["email"];
    // $password = $_POST["password"];
    $email = "406346220@gapp.fju.edu.tw";
    $password = "333333";
    $token = substr($email, 0, 2).rand(10000, 99999); //email前四碼+亂數四碼

    function loginSuccess() {
        global $con, $token, $email, $password, $response; //設定全域變數
        $statement = mysqli_prepare($con, "SELECT * FROM user WHERE email = ? AND password = ?"); //設定要執行的SQL指令，以?代表參數
        mysqli_stmt_bind_param($statement, "ss", $email, $password); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_store_result($statement); //將結果回傳並儲存
        mysqli_stmt_bind_result($statement, $colUserID, $colToken, $colEmail, $colPassword, $colName,
        $colSex, $colBirthMonth, $colBirthDate, $colBirthStatus, $colEmotionalStatus, $colMajor, $colClub, $colHobby,
        $colFavorClass, $colFavorCity, $colConfusion, $colTalent, $colDream, $colImage, $colPairLordStatus, $colPairAngelStatus); //回傳結果與變數連結
        $count = mysqli_stmt_num_rows($statement); //回傳列數

        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                $response["userid"] = $colUserID;
                $response["token"] = $token;
                $response["email"] = $colEmail;
                $response["password"] = $colPassword;
                $response["name"] = urlencode($colName);
                $response["sex"] = $colSex;
                $response["birth_month"] = $colBirthMonth;
                $response["birth_date"] = $colBirthDate;
                $response["birth_status"] = $colBirthStatus;
                $response["emotional_status"] = urlencode(index_to_emotional($colEmotionalStatus));
                $response["major"] = urlencode(index_to_major($colMajor));
                $response["club"] = urlencode($colClub);
                $response["hobby"] = urlencode($colHobby);
                $response["favorite_class"] = urlencode($colFavorClass);
                $response["favorite_city"] = urlencode($colFavorCity);
                $response["confusion"] = urlencode($colConfusion);
                $response["talent"] = urlencode($colTalent);
                $response["dream"] = urlencode($colDream);
                $response["image"] = urlencode(img_to_base64($colImage)); //解決base64解碼錯誤問題須加urlencode()
                $response["pair_lord_status"] = $colPairLordStatus;
                $response["pair_angel_status"] = $colPairAngelStatus;
            }
            return true;
        } else {
            return false;
        }
    }

    function resetToken() {
        global $con, $token, $email, $password;
        $statement = mysqli_prepare($con, "UPDATE user SET token = ? WHERE email = ? AND password = ?");
        mysqli_stmt_bind_param($statement, "sss", $token, $email, $password);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
    }

    function getUserCount() {
        global $con, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM user");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        $response["user_count"] = $count;
    }

    function getFriendCount() {
        global $con, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM friend WHERE lord = ? OR angel = ?");
        mysqli_stmt_bind_param($statement, "ii", $response["userid"], $response["userid"]);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        $response["friend_count"] = $count;
    }

    $response = array();
    $response["success"] = false;

    if (loginSuccess()) {
        resetToken();
        getUserCount();
        getFriendCount();
        $response["success"] = true;
    } else {
        // echo "Login failed!";
        $response["error"] = "loginFailed";
    }

    echo urldecode(json_encode($response));
?>
