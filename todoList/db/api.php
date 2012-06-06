<?php
header("Content-Type: text/javascript", true);

/*
 * -----------------------------------------------------------------------------
 * VARS
 */
/*
 * actions
 */
$getList = "getList";
$getListsInfo = "getListsInfo";

/*
 * var names
 */
$actionVName = "action";
$callBackVName = "callBack";
$listIdVName = "listId";

/*
 * error messages
 */
$genericErrorMessage = "An API error has occured.";
$notAuthorizedMessage = "You are not authorized to use this page.";

//missing variable messages
$noActionMessage = "An action name must be specified.";
$noCallBackMessage = "A call back function name must be specified.";
$noUserIdMessage = "A user ID must be supplied for this operation.";
$noListIdMessage = "A list ID must be supplied for this operation.";
$noListsMatchMessage = "No TODO Lists match your query.";

/*
 * -----------------------------------------------------------------------------
 * SCRIPT
 */

require("woopsydaisy.php");
mysql_connect($DB_URL, $DB_UNAME, $DB_PWORD);
mysql_select_db($DB_NAME);
unset($DB_URL, $DB_UNAME, $DB_PWORD, $DB_NAME);

$userId = getUserId();
$loggedIn = $userId > 0 && gettype($userId) == "integer";
$hasAction = isset($_GET[$actionVName]);
$hasCallBack = isset($_GET[$callBackVName]);

if ($loggedIn && $hasAction && $hasCallBack) {

$action = $_GET[$actionVName];
$callBack = $_GET[$callBackVName];

if ($action == $getList) {
    $listId = $_GET[$listIdVName];
    makeListInfo($callBack, $userId, $listId);
} else if ($action == $getListsInfo) {
    makeListsInfo($callBack, $userId);
}

} else {
    if (!$hasCallBack) {
        echo 0;
    } else if (!$loggedIn) {
        makeError($_GET[$callBackVName], $notAuthorizedMessage);
    } else if (!$hasAction) {
        makeError($_GET[$callBackVName], $noActionMessage);
    } else {
        makeError($_GET[$callBackVName], $genericErrorMessage);
    }
}

/*
 * -----------------------------------------------------------------------------
 * FUNCTIONS
 */
function makeJSONResponse($callBackName, $dataArray/*, $mode*/) {
    echo $callBackName."(".json_encode($dataArray).");";
}

function makeError($callBackName, $message/*, $mode*/) {
    $jsonMessage = array(
        "response" => 0,
        "message" => $message
    );
    makeJSONResponse($callBackName, $jsonMessage, $mode);
}

function makeListInfo($callBack, $userId, $listId) {
    global $noListIdMessage;
    global $noUserIdIdMessage;
    global $noListsMatchMessage;

    if ($userId > 0) {
        if ($listId) {
            $query =
                "SELECT * FROM lists WHERE PK_ID=$listId AND userid=$userId";
            $jsonMessage = mysql_fetch_assoc(mysql_query($query));
            if (!$jsonMessage) {
                makeError($callBack, $noListsMatchMessage);
            } else {
                makeJSONResponse($callBack, $jsonMessage);
            }
        }
        else {
            makeError($callBack, $noListIdMessage);
        }
    } else {
        makeError($callBack, $noUserIdMessage);
    }
}

function makeListsInfo($callBack, $userId) {
    global $noUserIdMessage;

    if ($userId) {
        $query = "SELECT * FROM lists WHERE userid = $userId";
        $result = mysql_query($query);
        $listArray = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $listArray[$i] = $row;
            $i++;
        }
        $jsonMessage = array(
            "response" => 1,
            "listsInfo" => $listArray
        );
        makeJSONResponse($callBack, $jsonMessage);
    } else {
        makeError($callBack, $noUserIdMessage);
    }
}


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

function getUserMode() {
    global $userId;

    session_start();
    if (isset($_SESSION["uname"])) {
        $query = "SELECT mode FROM users WHERE userid = $userId";
        $row = mysql_fetch_assoc(mysql_query($query));
        return $row["mode"];
    } else {
        return 0;
    }
}
?>
