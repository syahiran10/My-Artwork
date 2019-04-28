<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}

extract($_POST);

$id_paid = $_POST['id_paid']; 

$ext = explode('.', strtolower($_FILES['file']['name']) ); // whats the extension of the file
$num = count($ext);
$num = $num - 1;
$ext = $ext[$num];

$file_name = $_FILES['file']['name']; 
$final_name = $id_paid.'.'.$ext;
$final_dir = 'receipt/'.$final_name;		

$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
$upload_exts = end(explode(".", $_FILES["file"]["name"]));

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($upload_exts, $file_exts))
{
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
}
else
{
	
echo "Upload: " . $final_name . "";
echo "Type: " . $_FILES["file"]["type"] . "<br>";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

//change old name to new name based on booking id
$temp = explode(".",$_FILES["file"]["name"]);
$newfilename = $id_paid . '.' .end($temp);	

// Enter your path to upload file here
if (file_exists("receipt/" .$newfilename))
{
echo "<div class='error'>"."(".$newfilename.")".
" already exists. "."</div>";
}
else
{


move_uploaded_file($_FILES["file"]["tmp_name"],"receipt/" . $newfilename);
echo "<div class='sucess'>"."Stored in: " ."receipt/" . $final_name."</div>";

$sql_update = "UPDATE tblbooking 
				SET
					
					n_photo = 	'$newfilename',
					path	=	'$final_dir',
					payment	=	'In Progress'
	
				WHERE id = '$id_paid' ";

		$result_update = mysql_query($sql_update) or die(mysql_error());
			
		header('Location: my-booking.php?paid');
		exit();

}
}
}
else
{
echo "<div class='error'>Invalid file</div>";
}


?>