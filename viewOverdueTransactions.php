<?php
print "<h1>View Overdue Transactions</h1>";
require 'calculateInterest.php';
require 'connectToBapaDb.php';
$currentTime=time();
			if(!$lateTransactions=$db->query("SELECT * FROM transactions WHERE expectedDOR<$currentTime AND paid='no'"))
			die('There was an error connecting to database [' . $db->error . ']');
print "<br><br><table border=\"1\"> <th>Customer ID</th><th>Item</th><th>Item Value</th><th>Money Borrowed</th><th>Interest</th><th>Description</th><th>Expected Pay Day</th><th>Transaction Date</th>";
while($lateTransaction=$lateTransactions->fetch_assoc())
{
$id=$lateTransaction['customerID'];
$item=$lateTransaction['item'];
$itemValue=$lateTransaction['itemValue'];
$moneyBorrowed=$lateTransaction['moneyBorrowed'];
$moneyOwed=calculateInterest($moneyBorrowed, $lateTransaction['timeSubmitted']);
$description=$lateTransaction['description'];
$expectedDOR=date('d-m-Y', $lateTransaction['expectedDOR']);
$timeSubmitted=date('d-m-Y', $lateTransaction['timeSubmitted']);
print "<tr><td>$id</td> <td>$item</td><td>$itemValue</td><td>$moneyBorrowed</td><td>$moneyOwed</td><td>$description</td><td>$expectedDOR</td><td>$timeSubmitted</td></tr>";
}
print "</table>";
require 'returnToMenu.php';
?>