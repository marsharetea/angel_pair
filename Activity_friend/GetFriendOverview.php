<?php
    // require("password.php");
    include("../major_trans.php");
    include("../Activity_image/DownloadImg.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $token = $_POST["token"];
    // $index = $_POST["index"];
    $userID = 2;
    $token = "4056842";
    $index = 0;

    $friends = array();

    function downloadFriend() {
        global $con, $userID, $token, $friends, $response;
        $statement = mysqli_prepare($con, "SELECT relationid, lord, angel FROM friend WHERE lord = ? OR angel = ?");
        mysqli_stmt_bind_param($statement, "ii", $userID, $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colRelationID, $colLord, $colAngel);
        $count = mysqli_stmt_num_rows($statement);

        $response["friend_count"] = $count;
        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                if ($colLord != $userID)
                    $friends[] = [$colLord, $colRelationID];
                if ($colAngel != $userID)
                    $friends[] = [$colAngel, $colRelationID];
            }
            return true;
        } else {
            return false;
        }
    }

    function getFriendInfo() {
        global $con, $userID, $token, $index, $friends, $response;
        $statement = mysqli_prepare($con, "SELECT userid, sex, major, image FROM user WHERE userid = ?");
        mysqli_stmt_bind_param($statement, "i", $friends[$index][0]);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colUserID, $colSex, $colMajor, $colImage);
        while (mysqli_stmt_fetch($statement)) {
            $response["userid"] = $colUserID;
            $response["sex"] = $colSex;
            $response["major"] = urlencode(index_to_major($colMajor));
            $response["image"] = urlencode(img_to_base64($colImage));
            $response["relationid"] = $friends[$index][1];
        }
    }

    $response = array();
    $response["success"] = false;

    if (downloadFriend()) {
        print_r($friends);
        getFriendInfo();
        $response["success"] = true;
    } else {
        // echo "Get friend failed or No friend!";
        $response["error"] = "noFriend";
    }

    echo urldecode(json_encode($response));
?>
