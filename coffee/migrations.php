<?php
	$sqlquery = "CREATE TABLE IF NOT EXISTS cart (id int AUTO_INCREMENT PRIMARY KEY, users_id CHAR(255), product_id CHAR(255), quantity CHAR(255), addat_att date)";

	if (!mysqli_query($conn, $sqlquery)) {
		print mysqli_error($conn);
	}
?>