<?php
    // require("password.php");
    include("../major_trans.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    // $userID = $_POST["userid"];
    // $index = $_POST["index"];
    $userID = 2;
    $index = 1;
    $interval = 8;
    $articles = array();

    function getArticle() {
        global $con, $userID, $index, $interval, $articles, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM confession ORDER BY articleid DESC");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colArticleID, $colUserID, $colDate, $colTime, $colHead, $colArticle);

        $count = mysqli_stmt_num_rows($statement);
        $response["article_count"] = $count;

        $start = ($index-1)*$interval;
        if ($response["article_count"] < $index*$interval) $end = $response["article_count"]; else $end = $index*$interval;

        if ($count > 0) {
            $i = 0;
            while (mysqli_stmt_fetch($statement)) {

                if ($i >= $start && $i < $end) {

                    $poster_info = getPosterInfo($colUserID);
                    $colSex = $poster_info[0];
                    $colMajor = $poster_info[1];

                    $likeCount = likeCount($colArticleID);
                    $like = checkLike($colArticleID, $userID);

                    $messageCount = messageCount($colArticleID);

                    $colDate = explode("/", $colDate);
                    $colDate = (int)$colDate[1]."月".(int)$colDate[2]."日";
                    $colTime = explode(":", $colTime);

                    if ((int)$colTime[0] > 12) {
                        $colTime = "下午".((int)$colTime[0]-12).":".$colTime[1];
                    } elseif ((int)$colTime[0] == 12) {
                        $colTime = "下午".(int)$colTime[0].":".$colTime[1];
                    } else {
                        $colTime = "上午".(int)$colTime[0].":".$colTime[1];
                    }

                    $articles[] = array("articleid" => $colArticleID, "userid" => $colUserID, "sex" => $colSex,
                    "major" => urlencode(index_to_major($colMajor)), "date_time" => urlencode($colDate.$colTime),
                    "head" => urlencode($colHead), "article" => urlencode($colArticle), "like_count" => $likeCount,
                    "like" => $like, "message_count" => $messageCount);

                }
                $i++;
            }

            $response["articles"] = $articles;
            $response["article_count"] -= $index*$interval;
            return true;
        } else {
            return false;
        }
    }

    function getPosterInfo($userID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT sex, major FROM user WHERE userid = ?");
        mysqli_stmt_bind_param($statement, "i", $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colSex, $colMajor);
        while (mysqli_stmt_fetch($statement)) {
            if ($userID == 2) {
                $colSex2 = 2;
            } else {
                $colSex2 = $colSex;
            }

            $colMajor2 = $colMajor;
        }
        return array($colSex2, $colMajor2);
    }

    function likeCount($articleID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT * FROM presslike_confession WHERE articleid = ?");
        mysqli_stmt_bind_param($statement, "i", $articleID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $likeCount = mysqli_stmt_num_rows($statement);
        return $likeCount;
    }

    function checkLike($articleID, $userID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT * FROM presslike_confession WHERE articleid = ? AND userid = ?");
        mysqli_stmt_bind_param($statement, "ii", $articleID, $userID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $count = mysqli_stmt_num_rows($statement);
        return $count;
    }

    function messageCount($articleID) {
        global $con;
        $statement = mysqli_prepare($con, "SELECT * FROM message_confession WHERE articleid = ?");
        mysqli_stmt_bind_param($statement, "i", $articleID);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $messageCount = mysqli_stmt_num_rows($statement);
        return $messageCount;
    }

    $response = array();
    $response["success"] = false;

    if (getArticle()) {
        $response["success"] = true;
    } else {
        // echo "Get article failed or No article!";
        $response["error"] = "noArticle";
    }

    echo urldecode(json_encode($response));
?>
