<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>UPDATE CUSTOMER:</h1>
<b>Enter ID Number to update.<br><br></b>
<form name="formName" action="updateCustomer.php" method="post" onsubmit="return validateForm()">
ID Number:  <input type="text" name="licenseID"><br><br>
<input type="hidden" name="check_submit" value="1">
<input class="submit" type="submit" name="Submit">
</form>

<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["licenseID"].value;
			for(var x=0; x<array.length; x++)
			{
				if(array[x]=="" || array[x]==null){
				alert("All fields must be filled out");
				return false;
				}
			}
		}
</script>
BLOCK;
require 'returnToMenu.php';
	}
	
	function processForm(){
	$array=$_POST;
	$licenseID=$array['licenseID'];
	require 'connectToBapaDb.php';
	
	if(!$customersInfo=$db->query("SELECT * FROM customerinfo WHERE ID=\"{$licenseID}\" LIMIT 1"))
			die('There was an error connecting to database [' . $db->error . ']');
	$rows=$customersInfo->num_rows;
		if($rows==0)
		{
		print "<p style=\"color:red;\"> There if no customer with ID number \"<b>$licenseID</b>\" registered. If you would like to add a new customer, please go to the menu and click \"Add Customer\"</p>";
		require 'returnToMenu.php';		
		}
		
		else
		{
		$customerInfo=$customersInfo->fetch_assoc();
$name=$customerInfo['name'];
$licenseID=$customerInfo['ID'];
$phoneNumber=$customerInfo['phoneNumber'];
$address=$customerInfo['address'];
$transactions=$customerInfo['transactions'];
print <<<HTMLBLOCK
<h1>UPDATE CUSTOMER:</h1>
<b>Change the information and click submit in order to change the customer's information.</b> <br><br>
<form name="formName" action="updateCustomer2.php" method="post" onsubmit="return validateForm()">
Name:  <input type="text" name="name" value="$name"><br><br>
ID Number:  <input type="text" name="licenseID" value="$licenseID"><br><br>
Phone Number:	<input type="text" name="phoneNumber" value="$phoneNumber"><br><br>
Address:	<input type="text" name="address" value="$address"><br><br>
Transaction Number: <input type="text" name="transactions" value="$transactions">
<input type="hidden" name="check_submit" value="1"><br><br>
<input class="submit" type="submit" name="Submit">
</form>
<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["name"].value;
		array[1]=document.forms["formName"]["licenseID"].value;
		array[2]=document.forms["formName"]["phoneNumber"].value;
		array[3]=document.forms["formName"]["address"].value;
		array[4]=document.forms["formName"]["transactions"].value;
			for(var x=0; x<array.length; x++)
			{
				if(array[x]=="" || array[x]==null){
				alert("All fields must be filled out");
				return false;
				}
			}
		}
</script>
HTMLBLOCK;
		}
		require 'returnToMenu.php';
	}
?>