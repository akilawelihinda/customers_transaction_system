<?php
	$array=$_POST;
	$licenseID=$array['idNumber'];
	$reason=$array['reason'];
require 'connectToBapaDb.php';
$statement = $db->prepare("INSERT INTO blocklist VALUES(?, ?)");
$zero=0;
$statement->bind_param('ss', $licenseID, $reason);
	if(!$statement->execute())
		die('There was an error in submitting this data [' . $statement->error . ']');
print "<p style=\"color:green;\">This customer has been successfully added to the block list!</p>";
require 'returnToMenu.php';
?>