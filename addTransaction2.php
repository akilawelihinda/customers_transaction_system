<?php
$ID=$_POST['ID'];
$item=$_POST['name'];
$itemValue=$_POST['itemValue'];
$description=$_POST['description'];
$expectedDOR=$_POST['expectedDOR'];
$expectedDOR = str_replace('/', '-', $expectedDOR);
$expectedDOR=strtotime($expectedDOR);
$moneyBorrowed=$_POST['moneyBorrowed'];
$timeSubmitted=time();
$paid="no";
require 'connectToBapaDb.php';
	
	$statement = $db->prepare("INSERT INTO transactions VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	$statement->bind_param('ssiisiis', $ID, $item, $itemValue, $moneyBorrowed, $description, $expectedDOR, $timeSubmitted, $paid);
	if(!$statement->execute())
		die('There was an error in adding this transaction [' . $statement->error . ']');
	else
	{
	if(!$db->query("UPDATE customerinfo SET transactions=transactions+1 WHERE ID=\"$ID\""))
            die('There was an error connecting: Database unable to connect [' . $db->error . ']');
	print "<p style=\"color:green;\">This transaction has been successfully added!</p>";
	require 'returnToMenu.php';
	}
?>