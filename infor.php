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
		<div class="infor">
			<?php
			
				$user = 'root';
				$pass = '';
				$ndb = 'URLDB';
		
				$db = new mysqli('localhost', $user, $pass, $ndb) or die("Unable to connect");
				
				if ($db->connect_error){
					die("Connection failed: " . $db->connect_error);
				}
				
				echo "<table border='5' width='100%'>";
				echo "<tr>";
				echo "<th COLSPAN=2>";
					echo "<h2>TOTAL HITS</h2>";
				echo "</th>";
				echo "</tr>";
				echo "<tr>";
					//echo "<td>URL</td>";
					echo "<td>SHORT URL</td>"; 
					echo "<td>TOTAL HITS</td>";
				echo "</tr>";
				
				$sql = "SELECT IDURL.URL, IDURL.SURL, SUM(Hit) FROM THONGKE, IDURL WHERE THONGKE.Id = IDURL.ID GROUP BY THONGKE.Id";
				$result = $db->query($sql);
				
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()) {
						echo "<tr>";
						//	echo "<td>".$row["URL"]."</td>";
							echo "<td>".$row["SURL"]."</td>";
							echo "<td>".$row["SUM(Hit)"]."</td>";
						echo "</tr>";
						
					}
				} else {
					echo "0 results";
				}
				
				$sql = "SELECT IDURL.SURL, THONGKE.Date, THONGKE.Hit FROM THONGKE, IDURL WHERE IDURL.ID = THONGKE.Id and THONGKE.Date BETWEEN SUBDATE(CURDATE(), 30) AND CURDATE()";
				$result = $db->query($sql);
				
				echo "<table border='5' width='100%'>";
				echo "<tr>";
				echo "<th COLSPAN=3>";
					echo "<h2>DAILY HITS FOR THE LAST 30 DAYS</h2>";
				echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>SHORT URL</td>";
					echo "<td>DATE</td>"; 
					echo "<td>HIT OF DATE</td>";
				echo "</tr>";
				
				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()) {
						echo "<tr>";
							echo "<td>".$row["SURL"]."</td>";
							echo "<td>".$row["Date"]."</td>";
							echo "<td>".$row["Hit"]."</td>";
						echo "</tr>";
					}
				} else {
					echo "0 results";
				}
				
				$db->close();
			?>
		</div>
		
	</body>
</html>
  