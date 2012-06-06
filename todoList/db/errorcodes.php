<?php
//0 => general API error
//1 => No error
//2 => Not authorized
//3 => no action was supplied
//4 => no call back was supplied
//5 => no user id was supplied
//6 => no list id was supplied
//7 => no lists matched the query
//8 => unable to retrieve user mode
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
