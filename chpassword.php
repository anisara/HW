<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "714586255", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$passwordold = trim($_POST['passwordold']);
		$passwordnew = trim($_POST['passwordnew']);
		$repassword = trim($_POST['repassword']);
		if($repassword == $passwordnew){
		$query = "SELECT * FROM LOGIN WHERE password='$passwordold'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$query = "UPDATE LOGIN SET password = '$passwordnew' WHERE password = '$passwordold'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Change fail.";
		}
		}else{
			echo "Change fail.";
		}
	};
	oci_close($conn);
?>

<form action='chpassword.php' method='post'>
	Passwordold <br>
	<input name='passwordold' type='input'><br>
	Passwordnew<br>
	<input name='passwordnew' type='password'><br><br>
	Re-Password
	<input name='repassword' type='password'><br>
	<input name='submit' type='submit' value='OK'>
</form>
