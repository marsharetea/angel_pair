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
    $userID = 1;
    $token = "ev97604";
    $mode = 1; //主人配對 1，天使配對 0
    $context = "hey my angel";
    $yoursID;

    function findYoursID() {
        global $con, $mode, $userID, $yoursID;
        if ($mode == 1) {
            $statement = mysqli_prepare($con, "SELECT lord FROM pair WHERE angel = ? AND status = 0");
        } else {
            $statement = mysqli_prepare($con, "SELECT angel FROM pair WHERE lord = ? AND status = 0");
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
            // $response["pair_lord_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 1 WHERE userid = ? AND token = ?");
        } else {
            // $response["pair_angel_status"] = 1;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 1 WHERE userid = ? AND token = ?");
        }
        mysqli_stmt_bind_param($statement, "is", $userID, $token); //stmt與變數做連結
        mysqli_stmt_execute($statement); //執行stmt

        $count = mysqli_affected_rows($con); //回傳mysql影響的筆數
        if ($count > 0) {
            if ($mode == 1) $response["pair_lord_status"] = 1; else $response["pair_angel_status"] = 1;
            return true;
        } else {
            return false;
        }
    }

    function updatePairStatusTo2() {
        global $con, $mode, $userID, $token, $yoursID, $response;
        if ($mode == 1) {
            // $response["pair_lord_status"] = 2;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = ? AND token = ?");
            $statement2 = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = ?");
        } else {
            // $response["pair_angel_status"] = 2;
            $statement = mysqli_prepare($con, "UPDATE user SET pair_angel_status = 2 WHERE userid = ? AND token = ?");
            $statement2 = mysqli_prepare($con, "UPDATE user SET pair_lord_status = 2 WHERE userid = ?");
        }
        mysqli_stmt_bind_param($statement, "is", $userID, $token);
        mysqli_stmt_execute($statement);
        $count = mysqli_affected_rows($con);
        mysqli_stmt_bind_param($statement2, "i", $yoursID);
        mysqli_stmt_execute($statement2);
        $count2 = mysqli_affected_rows($con);

        if ($count > 0 && $count2 > 0) {
            if ($mode == 1) $response["pair_lord_status"] = 2; else $response["pair_angel_status"] = 2;
            return true;
        } else {
            return false;
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

    function sendFireBase() {
        global $con, $userID, $yoursID, $mode, $response;
        $filebase = fireBase($con, $userID, $yoursID, $mode);
        $response["lordid"] = $filebase["lordid"];
        $response["angelid"] = $filebase["angelid"];
        $response["lordcontext"] = $filebase["lordcontext"];
        $response["angelcontext"] = $filebase["angelcontext"];
    }

    $response = array();
    $response["success"] = false;

    findYoursID();
    if (confirmPair()) {
        // pair success
        if (updatePairStatusTo2()) {
            addRelation($con, $userID, $yoursID, $mode);
            addGreet($con, $userID, $yoursID, $mode, $context);
            sendFireBase();
            $response["success"] = true;
        } else {
            $response["error"] = "dataError";
        }
    } else {
        // not pair
        if (updatePairStatusTo1()) {
            tempRelation($con, $userID, $yoursID, $mode);
            addGreet($con, $userID, $yoursID, $mode, $context);
            $response["success"] = true;
        } else {
            $response["error"] = "dataError";
        }
    }

    echo json_encode($response);
?>
