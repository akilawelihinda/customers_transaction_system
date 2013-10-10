<?php
print "<h1>View Block List</h1>";
require 'connectToBapaDb.php';
			if(!$blockListPeople=$db->query("SELECT * FROM blocklist"))
			die('There was an error connecting to database [' . $db->error . ']');
print "<br><br><table border=\"1\"> <th>Customer ID</th><th>Reason</th>";
while($person=$blockListPeople->fetch_assoc())
{
$id=$person['customerID'];
$reason=$person['reason'];
print "<tr><td>$id</td> <td>$reason</td></tr>";
}
print "</table>";
require 'returnToMenu.php';
?>