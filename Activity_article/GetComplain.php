<?php
    // require("password.php");

    // $con = mysqli_connect("my_host", "my_user", "my_password", "my_database");
    $con = mysqli_connect("127.0.0.1", "root", "1234", "angel_pair"); //連結資料庫
    mysqli_set_charset($con, "utf8"); //中文亂碼

    function getArticle() {
        global $con, $response;
        $statement = mysqli_prepare($con, "SELECT * FROM complain");
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        mysqli_stmt_bind_result($statement, $colArticleID, $colUserID, $colDate, $colTime, $colHead, $colArticle);

        $count = mysqli_stmt_num_rows($statement);
        $response["article_count"] = $count;

        if ($count > 0) {
            while (mysqli_stmt_fetch($statement)) {
                $response[] = array("articleid" => $colArticleID, "userid" => $colUserID, "date" => $colDate, "time" => $colTime, "head" => $colHead, "article" => $colArticle);
            }
            return true;
        } else {
            return false;
        }
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
