<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $articleID = $_POST["articleid"];
    // $userID = $_POST["userid"];
    // $mode = $_POST["mode"];
    $articleID = 2;
    $userID = 4;
    $mode = 1;

    function pressLike() {
        global $con, $articleID, $userID;
        if (!checkLike($articleID, $userID)) {
            $statement = mysqli_prepare($con, "INSERT INTO presslike_confession (articleid, userid) VALUES (?, ?)");
            mysqli_stmt_bind_param($statement, "ii", $articleID, $userID);
            mysqli_stmt_execute($statement);

            if (mysqli_affected_rows($con) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function recoverLike() {
        global $con, $articleID, $userID;
        if (checkLike($articleID, $userID)) {
            $statement = mysqli_prepare($con, "DELETE FROM presslike_confession WHERE articleid = ? AND userid = ?");
            mysqli_stmt_bind_param($statement, "ii", $articleID, $userID);
            mysqli_stmt_execute($statement);

            if (mysqli_affected_rows($con) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function checkLike($articleID, $userID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT * FROM presslike_confession WHERE articleid = ? AND userid = ?");
        mysqli_stmt_bind_param($statement, "ii", $articleID, $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    $response = array();
    $response["success"] = false;

    if ($mode == 1) {
        if (pressLike()) {
            $response["success"] = true;
        } else {
            $response["error"] = "pressLikeFailed";
        }
    } else {
        if (recoverLike()) {
            $response["success"] = true;
        } else {
            $response["error"] = "recoverLikeFailed";
        }
    }

    echo json_encode($response);
?>
