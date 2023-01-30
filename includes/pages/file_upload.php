<?php require('../connection.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
</head>
<body>
	<form method="POST" action="file_upload.php" enctype="multipart/form-data">
		
		<input type="file" name="file" multiple="multiple"><p>
		<input type="text" name="title"><p>
		<input type="submit" name="submit" value="Upload files" >
		<input type="submit" name="Create" Value="Create Folder" >
	</form>

</body>
</html>
<?php



if(isset($_POST["Create"])){
	$title = $_POST["title"];
	// Desired folder structure
	$structure = '../../client_documents/clients/'.$title;
	if(isset($_POST["Create"])){
	$title = $_POST["title"];
	$pname = rand(1000,10000)."-".$_FILES["file"]["name"];
	$tname= $_FILES["file"]["tmp_name"];

	$uploads_dir= '../../client_documents/clients/'.$title;
	// $uploads_dir1= 'C:/Users/M.P.WIJESEKARA/Desktop/menuja/'.$title;
	move_uploaded_file($tname, $uploads_dir.'/'.$pname);
	// move_uploaded_file($tname, $uploads_dir1.'/'.$pname);
	$sql = "INSERT INTO upload(file_name,file) VALUES ('$title','$pname')";

	if($conn->query($sql)==TRUE){
	echo "NEW RECORD CREATED SUCCESSFULLY";
	}
		else{
	echo"ERROR".$sql."<br>".$conn->error;
	}}


	// To create the nested structure, the $recursive parameter 
	// to mkdir() must be specified.

	if (!mkdir($structure, 0777, true)) {
	    die('Failed to create folders...');

	}
}


if(isset($_POST["submit"])){
	$title = $_POST["title"];
	$pname = $_FILES["file"]["name"];
	$tname= $_FILES["file"]["tmp_name"];
	// echo $pname.'<br>';
	$currentdir =  dirname(__DIR__);
echo $currentdir;
	
	
	$uploads_dir= 'C/xampp/htdocs/login_sample/ELECTRON-4-PHP/client_documents/clients/'.$title;
	if (move_uploaded_file($pname,$uploads_dir.'/')) {
		echo "uploaded";
	} else {
		echo "failed";
	}
	
}
else{
	echo"ERROR".$sql."<br>".$connection->error;

}
$connection->close();
?>
