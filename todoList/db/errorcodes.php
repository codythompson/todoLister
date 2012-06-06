<?php
$TODO_API_ERROR_CODES = array(
//0 => general API error
    "GEN_API_ERR" => 0,
//1 => No error
    "SUCCESS" => 1,
//2 => Not authorized
    "NOT_AUTH" => 2,
//3 => no action was supplied
    "NO_ACTION" => 3,
//4 => no call back was supplied
    "NO_CALLBACK" => 4,
//5 => no user id was supplied
    "NO_USERID" => 5,
//6 => no list id was supplied
    "NO_LISTID" => 6,
//7 => no lists matched the query
    "NO_LISTS_MATCH" => 7,
//8 => unable to retrieve user mode
    "UNABLE_TO_RET_USERMODE" => 8,
//9 => Server Script Error
    "SERVER_SCRIPT_ERROR" => 9
    );

$TODO_API_ERRORS = array(
    "An API error has occured.", //0
    "Success", //1
    "You are not authorized to use this page.", //2
    "An action name must be specified.", //3
    "A call back function name must be specified.", //4
    "A user ID must be supplied for this operation.", //5
    "A list ID must be supplied for this operation.", //6
    "No TODO Lists match your query.", //7
    "Unable to retrieve user mode."); //8
?>
