<?php

//   Changes date format into mysql date format Y-m-d
//   If no proper date is given by the search user, to local system date is taken as a default
function rightdate($str)
	{
	  $d=preg_split('/\//',$str);
	  if($d[2]=='yy')
	 	 $date=date("Y-m-d");
	  else 
      	$date=$d[2]."-".$d[1]."-". $d[0];	
		
	  return $date;
	
	}










?>