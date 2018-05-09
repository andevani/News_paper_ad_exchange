<?php 
function convert_date_to_mysql( $date ) {
	
	//11-12-1991
	
	$arr = explode('-',$date);
	
	$day = $arr[0];
	$month = $arr[1];
	$year = $arr[2];
	
	$mysql_date = $year . '-' . $month . '-' . $day;
	
	return $mysql_date; 
}
//convert_date_to_mysql('11-12-1991');

function convert_sqldate_to_date( $sqldate )
{
	$arr1 = explode('-' , $sqldate);

	$year = $arr1[0];
	$month = $arr1[1];
	$day = $arr1[2];
	
	$date = $day. '-' . $month . '-' . $year;
	
	return $date;
	
}
//convert_sqldate_to_date('2000-11-12');

?>