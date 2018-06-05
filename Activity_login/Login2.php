<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $email = $_POST["email"];
    // $password = $_POST["password"];
    $email = "401401087@mail.fju.edu.tw";
    $password = "0534";

    $statement = mysqli_prepare($con, "SELECT userid, token, email, password, name FROM user WHERE email = ?"); //設定要執行的SQL指令，以?代表參數
    mysqli_stmt_bind_param($statement, "s", $email); //stmt與變數做連結
    mysqli_stmt_execute($statement); //執行stmt
    mysqli_stmt_store_result($statement); //將結果回傳並儲存
    mysqli_stmt_bind_result($statement, $colUserID, $colToken, $colEmail, $colPassword, $colName); //回傳結果與變數連結

    $response = array();
    $response["success"] = false;

    while (mysqli_stmt_fetch($statement)) { //依序擷取資料表每一列
        // if (password_verify($password, $colPassword)) { //password_verify -> 驗證密碼是否與hash值密碼相同
        if ($password == $colPassword) {
            $response["success"] = true;
            $response["userid"] = $colUserID;
            $response["token"] = $colToken;
            $response["email"] = $colEmail;
            $response["password"] = $colPassword;
            $response["name"] = urlencode($colName); //urlencode -> 解決中文亂碼

            // $response[] = array('success' => true, 'userid' => $colUserID, 'token' => $colToken, 'email' => $colEmail); //回傳多個json格式
        }
    }

    echo urldecode(json_encode($response)); //urldecode -> 解決中文亂碼
?>
