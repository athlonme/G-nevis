<?php 
$con = mysqli_connect("localhost","root","","gn_db");
mysqli_set_charset($con ,'utf8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>delete</title>
</head>

<body>
<?php if (isset ($_GET['deltemppic']))
		  {
			$id = $_GET['deltemppic'];
			$sql = "DELETE FROM temppic WHERE `id` = '".$id."'";
		    mysqli_query($con , $sql) or die("can't del file");
		  }	
?>
</body>
</html>