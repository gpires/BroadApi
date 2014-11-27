<?php 
include('config.php'); 
include('header.php'); 

?>
<div id="wrapper">
<?php include('menu.php'); ?>
	<div id="rightContent">
	<h3>Season List</h3>
	
	<?php $select_series = mysqli_query($con,"SELECT * FROM series"); ?>
		<table class="data">
			<form action=""  method="POST">
			<tr class="data">
				<th class="data" width="30px">&diams;</th>
				<th class="data">Name</th>
				<th class="data">Codec</th>
				<th class="data">Resolution</th>
				<th class="data">Source</th>
				<th class="data">Container</th>
				<th class="data">Origin</th>
				<th class="data">Episode</th>
				<th class="data">Active</th>
			</tr><?php
			while($row = mysqli_fetch_array($select_series))
			{
			echo "<tr class=\"data\">";
			echo "<td class=\"data\"><input type=\"checkbox\" name=\"id\" id=\"id\" value=\"" . $row['id'] . "\"></td>\n";
			echo "<td class=\"data\"><a href=\"tabel.php?id=" . $row['id'] . "\">" . $row['name'] . "</a></td>\n";
			echo "<td class=\"data\">" . $row['codec'] . "</td>\n";
			echo "<td class=\"data\">" . $row['resolution'] . "</td>\n";
			echo "<td class=\"data\">" . $row['source'] . "</td>\n";
			echo "<td class=\"data\">" . $row['container'] . "</td>\n";
			echo "<td class=\"data\">" . $row['origin'] . "</td>\n";
			echo "<td class=\"data\">" . $row['category'] . "</td>\n";
			echo "<td class=\"data\">" . active($row['enabled']) . "</td>\n";
			echo "</tr>";
			}
			?>
		</table>
<input type="submit" class="button" value="Add">
<input type="submit" class="button" value="Edit">
</form>
<?php 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$serie_id = $_GET['id'];
	$select_series = mysqli_query($con,"SELECT season,ep FROM episodes where serie_id=$serie_id ORDER BY season DESC,ep DESC");

echo "<br><br><table class=\"data\"\">
		<th class=\"data\">Season</th>
		<th class=\"data\">Episode</th>
	</tr>";

	while($row = mysqli_fetch_array($select_series)){ 
		echo "<tr class=\"data\">";
		echo "<td class=\"data\">" . $row['season'] . "</td>";
		echo "<td class=\"data\">" . $row['ep'] . "</td>";
		echo "</tr>";
	}

echo "</table>";
}


function active($var) {
	if ($var == 1) {
		$image = "<img src=\"mos-css/img/oke.png\">";
	} else {
		$image = "<img src=\"mos-css/img/cross.png\">";
	} 
return $image;	
}



?>		
		
		
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>
