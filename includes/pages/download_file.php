<?php require('../connection.php');?>
<!DOCTYPE html>
<html>
<head>
    <title>file</title>
</head>
<body>
    <form method="POST" action="download_file.php">
<input type="text" name="search">
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
<?php

if(isset($_POST["submit"])){

    $name=$_POST["search"];
// This will return all files in that folder
$files = scandir("../../client_documents/clients/".$name);
 
// If you are using windows, first 2 indexes are "." and "..",
// if you are using Mac, you may need to start the loop from 3,
// because the 3rd index in Mac is ".DS_Store" (auto-generated file by Mac)
for ($a = 2; $a < count($files); $a++)
{
    ?>
    <p>
        <!-- Displaying file name !-->
        <?php echo $files[$a]; ?>
 
        <!-- href should be complete file path !-->
        <!-- download attribute should be the name after it downloads !-->
        <a href="upload/<?php echo $files[$a]; ?>" download="<?php echo $files[$a]; ?>">
            Download
        </a>
    </p>
    <?php
}}
    mysqli_close($connection);?>