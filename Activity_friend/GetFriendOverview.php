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
    // $token = "4056842";
    $index = 1;

    $friends = array();

    function downloadFriend() {
        global $con, $userID, $friends, $response;
        $statement = mysqli_prepare($con, "SELECT lord, angel, status FROM friend WHERE lord = ? OR angel = ?");
        mysqli_stmt_bind_param($statement, "ii", $userID, $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colLord, $colAngel, $colStatus);
        $count = mysqli_stmt_num_rows($statement);

        $response["friend_count"] = $count;
        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                if ($colLord != $userID)
                    $friends[] = [$colLord, 1, 0];
                if ($colAngel != $userID)
                    $friends[] = [$colAngel, 0, $colStatus];
            }
            return true;
        } else {
            return false;
        }
    }

    function getFriendBrief() {
        global $con, $userID, $index, $friends, $response;
        $start = ($index-1)*8;
        if ($response["friend_count"] < $index*8) $end = $response["friend_count"]; else $end = $index*8;

        for ($i=$start; $i < $end; $i++) {
            $statement = mysqli_prepare($con, "SELECT userid, sex, major, image FROM user WHERE userid = ?");
            mysqli_stmt_bind_param($statement, "i", $friends[$i][0]);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            mysqli_stmt_bind_result($statement, $colUserID, $colSex, $colMajor, $colImage);
            while (mysqli_stmt_fetch($statement)) {
                // $response["userid"] = $colUserID;
                // $response["sex"] = $colSex;
                // $response["major"] = urlencode(index_to_major($colMajor));
                // $response["image"] = urlencode(img_to_base64($colImage));

                $response[] = array("userid" => $colUserID, "sex" => $colSex, "major" => urlencode(index_to_major($colMajor)), "identify" => $friends[$i][1], "status" => $friends[$i][2]);
            }
        }
    }

    $response = array();
    $response["success"] = false;

    if (downloadFriend()) {
        getFriendBrief();
        $response["success"] = true;
    } else {
        // echo "Get friend failed or No friend!";
        $response["error"] = "noFriend";
    }

    echo urldecode(json_encode($response));
?>
