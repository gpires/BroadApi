<?php 
include('config.php');
include('class/functions.php'); 
include('header.php'); 
?>

<div id="wrapper">
<?php include('menu.php'); ?>
	<div id="rightContent">
	<h3>Logs</h3>


<?php	
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 20; // Set how many records do you want to display per page.
$startpoint = ($page * $per_page) - $per_page;
$statement = "`logs` ORDER BY `id` DESC";
$results = mysqli_query($con,"SELECT * FROM $statement LIMIT $startpoint,$per_page");
	echo "<form action=\"\" method=\"POST\">\n";
    echo "<table class=\"data\">
			<tr class=\"data\">
				<th class=\"data\" width=\"30px\">&diams;</th>
				<th class=\"data\">ID</th>
				<th class=\"data\">Message</th>
				<th class=\"data\">Date</th>
			</tr>";

if (mysqli_num_rows($results) != 0) {
    while ($row = mysqli_fetch_array($results)) {
        $message = decode_msg($row['id_msg']);
	
		echo "<tr class=\"data\">";
		echo "<td class=\"data\"><input type=\"checkbox\" name=\"id_checkbox\" id=\"id\" value=\"" .$row['id'] . "\"></td>\n";
		echo "<td class=\"data\">" .$row['id'] . "</td>\n";
		echo "<td class=\"data\"><b>".$message."</b> ".$row['msg_alt']."</td>\n";
		echo "<td class=\"data\">" . $row['date'] . "</td>\n";
		echo "</tr>";
    }
  
} else {
     echo "No records are found.";
}
echo "</table>";
// displaying paginaiton.
echo "<input type=\"submit\" class=\"button\" value=\"DELETE\"></form>";
echo pagination($statement,$per_page,$page,$url='?');
	

function decode_msg($var) {
	if($var == 1):
		$msg = 'Torrent ADDED:';
	elseif($var == 2): 
		$msg = 'Torrent URL ADDED:';
	else:
		$msg = 'ERROR:';
	endif;

return $msg;	
}

if ( (isset($_POST['id_checkbox'])) && (is_numeric($_POST['id_checkbox'])) ) { //Just DELETE one row at time. Will change on future
	$id = $_POST['id_checkbox'];
	$q = "DELETE FROM logs WHERE id=$id LIMIT 1";		
	mysqli_query($con,$q); 
	echo "<div class=\"informasi\">
	Log #$id: DELETED
	</div>";
}
?>
		
		
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>