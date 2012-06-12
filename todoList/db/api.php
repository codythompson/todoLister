<?php

require_once("apifuncs.php");

/* -----------------------------------------------------------------------------
 * Script
 */
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
    } else if ($action == $getListItems) {
        $listId = $_GET[$listIdVName];
        makeListItems($callBack, $listId, $userId);
    } else {
        makeJSONResponse($_GET[$callBackVName], null,
            $TODO_API_ERROR_CODES["UNSUPPORTED_ACTION"]);
    }

} else {
    if (!$hasCallBack) {
        echo 0;
    } else if (!$loggedIn) {
        makeJSONResponse($_GET[$callBackVName], null,
            $TODO_API_ERROR_CODES["NOT_AUTH"]);
    } else if (!$hasAction) {
        makeJSONResponse($_GET[$callBackVName], null,
            $TODO_API_ERROR_CODES["NO_ACTION"]);
    } else {
        makeJSONResponse($_GET[$callBackVName], null,
            $TODO_API_ERROR_CODES["SERVER_SCRIPT_ERROR"]);
    }
}
?>
