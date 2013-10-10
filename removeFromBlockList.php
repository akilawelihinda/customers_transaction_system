<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>REMOVE FROM BLOCK LIST:</h1>
<b>Enter customer ID Number to remove customer from the block list.<br><br></b>
<form name="formName" action="removeFromBlockList.php" method="post" onsubmit="return validateForm()">
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
	$licenseID=$_POST['licenseID'];
	require 'connectToBapaDb.php';
	if(!$license=$db->query("SELECT customerID FROM blocklist WHERE customerID=\"{$licenseID}\""))
			die('There was an error connecting to database [' . $db->error . ']');
	$rows=$license->num_rows;
		if($rows==0)
		{
		print "<p style=\"color:red;\">Customer with ID Number \"<b>$licenseID</b>\" has not been added to the block list. You cannot remove a customer from the block list when they are not currently in the block list.</p>";
		require 'returnToMenu.php';
		}
	else
	{
		if(!$license=$db->query("DELETE FROM blocklist WHERE customerID=\"{$licenseID}\""))
			die('There was an error connecting to database [' . $db->error . ']');
		print "<p style=\"color:green;\">Customer with ID Number \"<b>$licenseID</b>\" has been successfully removed from the block list.</p>";
		require 'returnToMenu.php';
	}
		
	}
?>