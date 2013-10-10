<?php
function calculateInterest($moneyBorrowed, $time){
	require 'connectToBapaDb.php';
		if(!$interestRates=$db->query("SELECT * FROM interest ORDER BY theOrder"))
			die('There was an error in recording this payment [' . $db->error . ']');
		$rateNumber=0;
		while($interestRate=$interestRates->fetch_assoc())
		{
		$rates[$rateNumber]=$interestRate['rate'];
		$rateNumber++;
		}
		$currentTime=time();
		
		if($moneyBorrowed<5000)
		{
			$diff =$currentTime - $time;

			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$months=$months+$years*12;
				if($days>=0 && $days<=7)
				{
				//return $moneyBorrowed*$rates[0]*$months+$moneyBorrowed;
				return $moneyBorrowed*$rates[0]*$months;
				}
				
				if($days>7 && $days<21)
				{
				//return $moneyBorrowed*$rates[0]*($months+0.5)+$moneyBorrowed;
				return $moneyBorrowed*$rates[0]*($months+0.5);
				}
				
				if($days>=21)
				{
				//return $moneyBorrowed*$rates[0]*($months+1)+$moneyBorrowed;
				return $moneyBorrowed*$rates[0]*($months+1);
				}	
		}
		
		elseif($moneyBorrowed<10000)
		{
		$diff = abs($currentTime - $time);

			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
				if($days>=0 && $days<=7)
				{
				//return $moneyBorrowed*$rates[1]*$months+$moneyBorrowed;
				return $moneyBorrowed*$rates[1]*$months;
				}
				
				if($days>7 && $days<22)
				{
				//return $moneyBorrowed*$rates[1]*($months+0.5)+$moneyBorrowed;
				return $moneyBorrowed*$rates[1]*($months+0.5);
				}
				
				if($days>=22)
				{
				//return $moneyBorrowed*$rates[1]*($months+1)+$moneyBorrowed;
				return $moneyBorrowed*$rates[1]*($months+1);
				}	
		}
		
		else
		{
			if($currentTime-$time<604800)
			{
			//return $moneyBorrowed*$rates[2]+$moneyBorrowed;
			return $moneyBorrowed*$rates[2];
			}
			else
			{
			//return $moneyBorrowed*$rates[3]+$moneyBorrowed;		
			return $moneyBorrowed*$rates[3];
			}
		}
	}
?>