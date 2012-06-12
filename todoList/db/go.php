<?php
require_once("apifuncs.php");

if ($mode > 0) {
    $_GET[$actionVName] = $getListItems;
    $_GET[$listIdVName] = $mode;
}
else {
    $_GET[$actionVName] = $getListsInfo;
}

require_once("api.php");
?>
