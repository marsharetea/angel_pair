<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $head = $_POST["head"];
    // $article = $_POST["article"];
    $userID = 2;
    $head = "我是李X";
    $article = "大奶妹gogogo~";

    date_default_timezone_set("Asia/Shanghai");
    $date = date("Y/m/d");
    $time = date("H:i:s");

    function AddArticle() {
        global $con, $userID, $head, $article, $date, $time;
        $statement = mysqli_prepare($con, "INSERT INTO complain (userid, date, time, head, article) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "issss", $userID, $date, $time, $head, $article);
        mysqli_stmt_execute($statement);

        $count = mysqli_affected_rows($con);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if (AddArticle()) {
        $response["success"] = true;
    } else {
        // echo "Add complain article failed!";
        $response["error"] = "addArticleFailed";
    }

    echo json_encode($response);
?>
