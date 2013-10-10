<?php
$array=$_POST;

require 'connectToBapaDb.php';
$counter=0;
$time=time();

foreach($array as $key=>$value)
{
	if($value=="skipMe" || $value=="Yes")
		continue;
		
	if(strpos($key, "AID"))
		continue;
	
	if(!$transaction=$db->query("UPDATE transactions SET paid='yes' WHERE timeSubmitted='$value'"))
		die('There was an error connecting to database [' . $db->error . ']');
		
	if(!$transactions=$db->query("SELECT * FROM transactions WHERE timeSubmitted='$value' LIMIT 1"))
		die('There was an error connecting to database [' . $db->error . ']');
		
	$transaction=$transactions->fetch_assoc();
	$id=$transaction['customerID'];
	
	if(!$rho=$db->query("UPDATE customerinfo SET transactions=transactions+1 WHERE ID='$id'"))
		die('There was an error connecting to database [' . $db->error . ']');
		
	
	$payed=$array["PAID$counter"];
	$newBorrowed=$transaction['moneyBorrowed']-$payed;
if($newBorrowed>0)
{
		$statement = $db->prepare("INSERT INTO transactions VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	$no='no';
	$time=$time+$counter;
	$statement->bind_param('ssiisiis', $transaction['customerID'], $transaction['item'], $transaction['itemValue'], $newBorrowed, $transaction['description'], $transaction['expectedDOR'], $time, $no);
		if(!$statement->execute())
			die('There was an error running the querySubmitVideo0 [' . $statement->error . ']');
}
$counter++;
}

print "<p style=\"color:green;\">Customer payments have successfully been recorded!</p>";
require 'returnToMenu.php';

?>