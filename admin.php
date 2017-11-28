<?php
include_once 'database/database.php';

session_start();

if(isset($_SESSION['user'])){
	$id = session_id();
}
else {
	echo"<script language='javascript' type='text/javascript'>alert('You must be logged on. Permission denied');window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<link rel="stylesheet" href="css/admin.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/admin.js"></script>
</head>

<body>
	<div align="center" class="adminButtons">
		<button class="adminBtn" id="closed">Closed Orders</button>
		<button class="adminBtn" id="order">Open Orders</button>
		<button class="adminBtn" id="messageButton">New messages</button>
		<a href="logout.php" class="logout">Logout</a>
	</div>

	<div align="center" class="tabela" id="openOrders">
		<br><br><h1>Open orders</h1>
		<table class="ordersTable">
			<thead>
				<tr>
					<th>#</th>
					<th>Order ID</th>
					<th>Client Name</th>
					<th>Client Email</th>
					<th>Address</th>
					<th>Price</th>
					<th>Send</th>
				</tr>
			</thead>
			<tbody>
				<?php
		            $cont = 0;
		            $connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
					mysql_select_db("bwm");

					$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1; //GET the page number from URL
	  				$perPage = 10; //Set number of items per page
	  				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


					$bool = false;

		            $sql = "SELECT * FROM ORDERS WHERE ALREADYSENT = false LIMIT {$start},{$perPage}"; // SQL Query to get the right amount of elements
		            $result = mysql_query($sql);

		            while($row = mysql_fetch_array($result)){
		            	$cont = $cont + 1;
		                Print "<tr>";
		                    Print '<td>'. $cont . "</td>";
		                    Print '<td class="orderid">'. $row['ORDERID'] . "</td>";
		                    Print '<td>'. $row['FULLNAME'] . "</td>";
		                    Print '<td>'. $row['EMAIL'] . "</td>";
		                    Print '<td>'. $row['address'] . "</td>";
		                    Print '<td>$'. $row['PRICE'] . "</td>";                  
		                    Print '<td>  <a href="#" class="sendOrder"><i class="material-icons">check</i></a> </td>';
				   		Print "</tr>";
	            	}
	          	?>
			</tbody>
		</table>

	<?php
		$sql  = mysql_query("SELECT * FROM ORDERS ");
	  	$total = mysql_num_rows($sql);
	  	$pages = ceil($total / $perPage);
	  	for ($i=1; $i <= $pages ; $i++) {
	  		if($i == $pages){
	    		echo '<a class="pages" href="closedorders.php?page='. $i .'">' . $i . '</a>';
	    	}
	    	else{
	    		echo '<a class="pages" href="closedorders.php?page='. $i .'">' . $i . '</a>';
	    		echo '<p class="separator"> - </p>';
	    	}
	  	}
	?>

	</div>

	<div align="center" class="tabela" id="closedOrders">
		<br><br><h1>Closed orders</h1>
		<table class="ordersTable">
			<thead>
				<tr>
					<th>#</th>
					<th>Order ID</th>
					<th>Client Name</th>
					<th>Client Email</th>
					<th>Address</th>
					<th>Price</th>
					<th>Send</th>
				</tr>
			</thead>
			<tbody>
				<?php
		            $cont = 0;
		            $connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
				    mysql_select_db("bwm");


					$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1; //GET the page number from URL
	  				$perPage = 10; //Set number of items per page
	  				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


					$bool = false;

		            $sql = "SELECT * FROM ORDERS WHERE ALREADYSENT = true LIMIT {$start},{$perPage}"; // SQL Query
		            $result = mysql_query($sql);

		            while($row = mysql_fetch_array($result)){
		                $cont = $cont + 1;
		                Print "<tr>";
		                    Print '<td>'. $cont . "</td>";
		                    Print '<td class="orderid">'. $row['ORDERID'] . "</td>";
		                    Print '<td>'. $row['FULLNAME'] . "</td>";
		                    Print '<td>'. $row['EMAIL'] . "</td>";
		                    Print '<td>'. $row['address'] . "</td>";
		                    Print '<td>$'. $row['PRICE'] . "</td>";                  
		                    Print '<td>  <a href="#" class="openOrder"><i class="material-icons">close</i></a> </td>';
				   		Print "</tr>";
		            }
				?>
			</tbody>
		</table>
	<?php
			$sql  = mysql_query("SELECT * FROM ORDERS ");
  				$total = mysql_num_rows($sql);
  				$pages = ceil($total / $perPage);
  				for ($i=1; $i <= $pages ; $i++) {
  					if($i == $pages){
    					echo '<a class="pages" href="closedorders.php?page='. $i .'">' . $i . '</a>';
    				}
    				else{
    					echo '<a class="pages" href="closedorders.php?page='. $i .'">' . $i . '</a>';
    					echo '<p class="separator"> - </p>';
    				}
  				}
		?>
		


	</div>
	<div class="message" id="message">
	<?php
		$connection = mysql_connect(HOST,USER,PASS) or die('Error connecting to MySQL server.');
		mysql_select_db("bwm");

		$page = !empty($_GET['message']) ? (int)$_GET['message'] : 1;
	  	$perPage = 1; //Set number of items per page
	  	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;


		$bool = false;

		$sql = "SELECT * FROM MESSAGES WHERE ALREADYREAD = false LIMIT {$start},{$perPage}"; // SQL Query
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)){
		    Print '<h1>Name: ' . $row['FIRSTNAME'] . " " . $row['LASTNAME'] . '</h1>';
		    Print '<h2>Email: ' . $row['EMAIL'] . '</h2>';
		    Print '<h3>Message</h3>';
			Print '<p>' . $row['MESSAGE'] . '</p>';   
			Print '<a href="reply.php?message='. $page .'"><i class="material-icons">reply</i></a> <br><br>';
		}

		$sql  = mysql_query("SELECT * FROM MESSAGES ");
	  	$total = mysql_num_rows($sql);
	  	$pages = ceil($total / $perPage);
	  	for ($i=1; $i <= $pages ; $i++) {
	  		if($i == $pages){
	    		echo '<a class="pages" href="admin.php?message='. $i .'&block=block">' . $i . '</a>';
	    	}
	    	else{
	    		echo '<a class="pages" href="admin.php?message='. $i .'&block=block">' . $i . '</a>';
	    		echo '<p class="separator"> - </p>';
	    	}
	  	}
	?>
	</div>

</body>
</html>