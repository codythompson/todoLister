<?php
//todo: don't use get use post
$uname = $_GET["uname"];
$pword = $_GET["pword"];

if (isset($_GET["logOut"])) {
    unAuth();
} else {
    auth($uname, $pword);
}

function unAuth() {
    session_start();
    unset($_SESSION["uname"]);
    if (isset($_SESSION["uname"])) {
        echo 0;
    } else {
        echo 1;
    }
}

function auth($uname, $pword) {
    //TODO: actually authenticate the user
    if (true) {
        session_start();
        $_SESSION["uname"] = $uname;
        echo 1;
        return true;
    } else {
        echo 0;
        return false;
    }
}

function getUserId() {
    session_start();
    if (isset($_SESSION["uname"])) {
        $uname = $_SESSION["uname"];
        $query = "SELECT userid FROM users WHERE uname = $uname";
        $row = mysql_fetch_assoc(mysql_query($query));
        return $row["userid"];
    } else {
        return 0;
    }
}
?>
