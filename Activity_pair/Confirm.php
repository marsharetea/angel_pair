<?php
    // require("password.php");
    include("../Activity_friend/AddRelation.php");
    include("../Activity_chat/Greet.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    // $mode = $_POST["mode"];
    // $conrext = $_POST["context"];
    $userID = 6;
    $token = "zz42462";
    $mode = 1;
    $context = "hello world!!!!!!";
    $yoursID;

    function findYoursID() {
        global $con, $mode, $userID, $yoursID;
        if ($mode == 1) {
            $statement = mysqli_prepare($con, "SELECT angel FROM pair WHERE lord = ? AND status = 0");
        } else {
            $statement = mysqli_prepare($con, "SELECT lord FROM pair WHERE angel = ? AND status = 0");
        }
        mysqli_stmt_bind_param($statement, "i", $userID); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colYoursID);
        while (mysqli_stmt_fetch($statement)) {
            $yoursID = $colYoursID;
        }
    }

    function updatePairStatusTo1() {
        global $con, $mode, $userID, $token, $response; //設定全域變數
        if ($mode == 1) {
            $response["pair_lord_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 1 WHERE userid = ? AND token = ?");
        } else {
            $response["pair_angel_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 1 WHERE userid = ? AND token = ?");
        }
        mysqli_stmt_bind_param($statement, "is", $userID, $token); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt
        mysqli_stmt_close($statement);
    }

    function updatePairStatusTo2() {
        global $con, $mode, $userID, $token, $yoursID, $response;
        if ($mode == 1) {
            $response["pair_lord_status"] = 2;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = ? AND token = ?");
            mysqli_stmt_bind_param($statement, "is", $userID, $token);
            mysqli_stmt_execute($statement);
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = ?");
            mysqli_stmt_bind_param($statement, "i", $yoursID);
            mysqli_stmt_execute($statement);
        } else {
            $response["pair_angel_status"] = 2;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = ? AND token = ?");
            mysqli_stmt_bind_param($statement, "is", $userID, $token);
            mysqli_stmt_execute($statement);
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = ?");
            mysqli_stmt_bind_param($statement, "i", $yoursID);
            mysqli_stmt_execute($statement);
        }
    }

    function confirmPair() {
        global $con, $mode, $userID, $token, $yoursID, $response;
        if ($mode == 1) {
            $statement = mysqli_prepare($con, "SELECT pair_angel_status FROM user WHERE userid = ?");
        } else {
            $statement = mysqli_prepare($con, "SELECT pair_lord_status FROM user WHERE userid = ?");
        }
        mysqli_stmt_bind_param($statement, "i", $yoursID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colPairStatus);

        while (mysqli_stmt_fetch($statement)) {
            if ($colPairStatus > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    $response = array();
    $response["success"] = false;

    findYoursID();
    // echo $yoursID;
    if (confirmPair()) {
        // pair success
        updatePairStatusTo2();
        addRelation($con, $userID, $yoursID, $mode);
        addGreet($con, $userID, $yoursID, $mode, $context);
        $response["success"] = true;
    } else {
        // not pair
        updatePairStatusTo1();
        tempRelation($con, $userID, $yoursID, $mode);
        addGreet($con, $userID, $yoursID, $mode, $context);
    }

    echo json_encode($response);
?>
