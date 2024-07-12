<?php
if (isset($_POST['submit'])) {
	include 'includes/conn.php';
	
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." Uploaded successfully." . "</h1>";
		echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']);
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$id = $data[0];
		$firstname = $data[1];
		$lastname = $data[2];
		$password = substr(md5(time()."".$id),0,6);
		$vpass = $password;
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		$conn->query("INSERT INTO voters (voters_id, password, firstname, lastname, photo,vpass) VALUES ('$id', '$password', '$firstname', '$lastname', '','$vpass')");
		
		}

	fclose($handle);

	echo "<script type='text/javascript'>alert('Successfully imported a CSV file!');</script>";
	echo "<script>document.location='voters.php'</script>";
}

?>