<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>BLOCK LIST:</h1>
<b>Enter ID Number to add a customer to the block list.<br><br></b>
<form name="formName" action="blockList.php" method="post" onsubmit="return validateForm()">
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
		if($rows>0)
		{
		print "<p style=\"color:red;\">Customer with ID Number $licenseID has already been added to the block list.</p>";
		require 'returnToMenu.php';
		}
		
		elseif(!$license=$db->query("SELECT ID FROM customerinfo WHERE ID=\"{$licenseID}\""))
			die('There was an error connecting to database [' . $db->error . ']');
		else if($license->num_rows==0)
		{
		print "<p style=\"color:red;\">Customer with ID Number \"<b>$licenseID</b>\" is not a registered customer. The customer must be added as a registered customer before he/she can be added to the block list.</p>";
		require 'returnToMenu.php';
		}
		
	else
	{
print <<<HTMLBLOCK
<b>Enter reason why customer is added to block list.</b><br><br>
<form name="formName" action="blockList2.php" method="post" onsubmit="return validateForm()">
<input type="hidden" name="idNumber" value="$licenseID">
Reason:  <input type="text" name="reason"><br><br>
<input type="hidden" name="check_submit" value="1"><br><br>
<input class="submit" type="submit" name="Submit">
</form>

<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["idNumber"].value;
		array[1]=document.forms["formName"]["reason"].value;
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
require 'returnToMenu.php';
	}
	}
?>