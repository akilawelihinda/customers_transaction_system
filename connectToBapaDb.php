<?php
$db=new mysqli("host_name","userName","Password","database_name");
	if (mysqli_connect_errno($db))
		echo "Failed to connect to database: " . mysqli_connect_error();
?>