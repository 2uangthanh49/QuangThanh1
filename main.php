<!DOCTYPE html>
<html>
  <head>
	<title>SHORTER URL</title>
	<link rel="stylesheet" type="text/css" href="css.css">
	<style>
		body {
			background-image: url("1.jpg");
            background-size: 1380px 720px;
            background-repeat: no-repeat;
		}
	</style>
    </head>
    <body>
	<div class="container">
		<ul>
			<li>
				<a href="main.php">HOME</a>
			</li>
			<li>
				<a href="infor.php">INFOR</a>
			</li>
		</ul>
	</div>
	<div>
		<form method="POST" id="form_input" align="center">
			<p id="p_input">INPUT HERE<p>
			<input type="text" id = "text_input" name = "shorten" value = ""/>
			<input type="submit" name = "Submit" id = "submit_input" value="Submit" />
		</form>
	</div>
	
	<!--Connect to file Switch, Shorten -->
	<?php
		include 'switch.php';
		include 'shorten.php';
	?>
	
    <?php	
		 //Get URL
		$temp = "";
		if (isset($_POST['Submit'])){
			$temp = $_POST['shorten'];
		}
        $digits = array();
        $surl = "";
        $ID = 0;
		
        $ID = urltoID($temp, $ID);
        $digits = idtoDigit($ID, $digits);
        $surl = digittoSURL($digits, $surl);
		
		//Connect to DB and add value to DB
		$user = 'root';
		$pass = '';
		$ndb = 'URLDB';
	
		$db = new mysqli('localhost', $user, $pass, $ndb) or die("Unable to connect");
		
		if($surl != 'shorten.me/') {
			$sql = "INSERT INTO IDURL (ID, URL, SURL)
			VALUES ('$ID', '$temp', '$surl')";
		
			if ($db->query($sql) === TRUE) {
				echo "<a id='url_output' href='$temp'>$surl</a>";
			} else {
				echo "<a id='url_output' href='$temp'>$surl</a>";
			}
		} else {
			echo "<p id='mess_input'>PLEASE INPUT A URL. TKS! </p>";
		}
		$db->close();
    ?>
	
	<!--FORM input short url -->
	<div class="form">
		<form id="form_short" method="POST" align="center">
			<p id="p_short">SURL<p>
			<input type="text" id = "text_short" name = "shortURL" value = ""/>
			<input type="submit" id = "submit_short" name = "Go" value="Go" />
		</form>
	</div>
	
	<!-- -->
	<?php
		$stemp = "";
		$Id = "";
		$hit = 0;
		$date = date("Y-m-d");
		$url ="";
		$row1 = "";
		
		if (isset($_POST['Go'])){
			$stemp = $_POST['shortURL'];
		}
		
		if ($stemp != "") {
			$db_found = new mysqli('localhost', $user, $pass, $ndb) or die ("Unable to connect");
			
			$result = $db_found->query("SELECT ID, URL FROM IDURL WHERE SURL = '$stemp'");
			
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$url = $row["URL"];
				$Id = $row["ID"];
				
				$sql = "INSERT INTO THONGKE (Id, Date, hit)
				VALUES ('$Id', '$date', '1')";
				
				if ($db_found->query($sql) === TRUE) {
				
				} else {
					$thit = $db_found->query("SELECT Hit FROM THONGKE WHERE Id = '$Id' and Date = '$date'");
					$row1 = $thit->fetch_assoc();
					$hit = $row1["Hit"] + 1;
					//echo $hit;
					$sql = "UPDATE THONGKE SET Hit = '$hit' WHERE Id = '$Id' and Date = '$date'";
					if ($db_found->query($sql) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $db_found->error;
					}
				}
				header("Location: $url"); /* Redirect browser */
				exit;
				echo "<a id='url_output' href='$url'>Click here</a>";
			} else {
				echo "<p id='mess_input'>THIS SHORT URL NOT HAVE IN DB</p>";
			}
			
			$db_found->close();
		}
		
		
		
	?>
	
  </body>
</html>