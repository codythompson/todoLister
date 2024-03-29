<?php
/*
 * api.php
 */

header("Content-Type: text/javascript", true);

require_once("errorcodes.php");

$TODOLIST_DEF_MODE_STR = "0";

/* -----------------------------------------------------------------------------
 * DB CONN
 */
require("woopsydaisy.php");
mysql_connect($DB_URL, $DB_UNAME, $DB_PWORD);
mysql_select_db($DB_NAME);
unset($DB_URL, $DB_UNAME, $DB_PWORD, $DB_NAME);

/* -----------------------------------------------------------------------------
 * actions
 */
$getList = "getList";
$getListsInfo = "getListsInfo";
$getListItems = "getListItems";
/*
 * var names
 */
$actionVName = "action";
$callBackVName = "callBack";
$listIdVName = "listId";

/* -----------------------------------------------------------------------------
 * Utility Functions
 */

function getUserId() {
    session_start();
    if (isset($_SESSION["uname"])) {
        $uname = $_SESSION["uname"];
        $query = "SELECT userid FROM users WHERE uname = '$uname'";
        $row = mysql_fetch_assoc(mysql_query($query));
        return intval($row["userid"]);
    } else {
        return 0;
    }
}

$userId = getUserId();

function getUserMode() {
    global $userId;

    session_start();
    if (isset($_SESSION["uname"])) {
        $query = "SELECT mode FROM users WHERE userid = $userId";
        $row = mysql_fetch_assoc(mysql_query($query));
        return intval($row["mode"]);
    } else {
        return -1;
    }
}

$mode = getUserMode();

function makeJSONResponse($callBackName, $dataArray,
        $errorCode=1) { //should find way to not use literal here

    global $mode;
    global $TODO_API_ERRORS;

    $responseArray = array(
        "response" => $errorCode,
        "message" => $TODO_API_ERRORS[$errorCode],
        "mode" => $mode,
        "data" => $dataArray);

    echo $callBackName."(".json_encode($responseArray).");";
}

/* -----------------------------------------------------------------------------
 * API functions
 */

function makeListInfo($callBack, $userId, $listId) {
    global $TODO_API_ERROR_CODES;

    if ($userId > 0) {
        if ($listId > 0) {
            $query =
                "SELECT * FROM lists WHERE PK_ID=$listId AND userid=$userId";
            $jsonMessage = mysql_fetch_assoc(mysql_query($query));

            if (!$jsonMessage) {
                makeJSONResponse($callBack, null,
                    $TODO_API_ERROR_CODES["NO_LISTS_MATCH"]);
            } else {
                makeJSONResponse($callBack, $jsonMessage);
            }

        } else {
            makeJSONResponse($callBack, null,
                $TODO_API_ERROR_CODES["NO_LISTID"]);
        }
    } else {
        makeJSONResponse($callBack, null, $TODO_API_ERROR_CODES["NO_USERID"]);
    }
}

function makeListsInfo($callBack, $userId) {
    global $TODO_API_ERROR_CODES;

    if ($userId > 0) {
        $query = "SELECT * FROM lists WHERE userid = $userId";
        $result = mysql_query($query);
        $listArray = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $listArray[$i] = $row;
            $i++;
        }
        makeJSONResponse($callBack, $listArray);
    } else {
        makeJSONResponse($callBack, null, $TODO_API_ERROR_CODES["NO_USERID"]);
    }
}

function makeListItems($callBack, $userId, $listId) {
    global $TODO_API_ERROR_CODES;

    if ($userId > 0) {
        if ($listId > 0) {
            $query =
                "SELECT * FROM items WHERE userid=$userId AND listId=$listId";
            $result = mysql_query($query);
            $listArray = array();
            $i = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $listArray[$i] = $row;
                $i++;
            }
            makeJSONResponse($callBack, $listArray);
        } else {
            makeJSONResponse($callBack, null,
                $TODO_API_ERROR_CODES["NO_LISTID"]);
        }
    } else {
        makeJSONResponse($callBack, null, $TODO_API_ERROR_CODES["NO_USERID"]);
    }
}


?>
