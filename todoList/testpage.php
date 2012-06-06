<?php
session_start();
$uname = $_SESSION["uname"];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>testola</title>

<script src="libs/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="scripts/todolist.js" type="text/javascript"></script>
<script src="db/api.php?action=getListsInfo&callBack=TODO_obj.setListsInfo"
        type="text/javascript">
</script>
</head>

<body>
<h1>todo list testing</h1>

<hr/>

<?php
if (isset($uname)) {
?>
logged in as: <b><?php echo $uname; ?></b>
<form action="db/auth.php" metho="get">
<input type="hidden" name="logOut" value="1" />
<input type="submit" value="logout" />
</form>
<?php
} else {
?>
not logged in.
<?php
}
?>

<hr/>

<form action="db/auth.php" method="get">
uname <input type="text" name="uname" />
<input type="submit" />
</form>

<hr/>

<div id="lists-container">
<!-- will be populated by javascript -->
</div>

</body>

</html>
