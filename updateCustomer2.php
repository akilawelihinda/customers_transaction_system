<?php
$name=$_POST['name'];
$licenseID=$_POST['licenseID'];
$phoneNumber=$_POST['phoneNumber'];
$address=$_POST['address'];
$transactions=$_POST['transactions'];
	require 'connectToBapaDb.php';
	
	$statement = $db->prepare("UPDATE customerinfo SET name=?, ID=?, phoneNumber=?, address=?, transactions=? WHERE ID=\"$licenseID\"");
	$statement->bind_param('ssssi', $name, $licenseID, $phoneNumber, $address, $transactions);
	if(!$statement->execute())
		die('There was an error in updating this customer [' . $statement->error . ']');
	else
	{
	print "<p style=\"color:green;\">This customer has been successfully updated!</p>";
	require 'returnToMenu.php';
	}
?>