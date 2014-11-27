<?php
error_reporting(0);
include('config.php'); 
include('class/jsonRPCClient.php');

$btn = new jsonRPCClient($btn_api_url);

$name = $_POST['name'];
$codec = $_POST['codec'];
$resolution = $_POST['resolution'];
$source = $_POST['source'];
$container = $_POST['container'];
$origin = $_POST['origin'];
$category = $_POST['category'];

$values = array("series" => $name,
			   "codec" => $codec,
			   "resolution" => $resolution,
			   "source" => $source,
			   "container" => $container,
			   "origin" => $origin,
			   "category" => $category
			   );
			   
$results = $btn->getTorrents($btn_api_key, array_filter($values), 10);

echo	"<table class=\"data\">
			<tr class=\"data\">
				<th class=\"data\" width=\"30px\">&diams;</th>
				<th class=\"data\">Name</th>
				<th class=\"data\">Codec</th>
				<th class=\"data\">Resolution</th>
				<th class=\"data\">Source</th>
				<th class=\"data\">Container</th>
				<th class=\"data\">Origin</th>
				<th class=\"data\">Category</th>
			</tr>";

foreach($results as $series) {
	foreach($series as $episode) {
	echo "<tr class=\"data\">";
			echo "<td class=\"data\"><input type=\"checkbox\" name=\"id\" id=\"id\" value=\"lol\"></td>\n";
			echo "<td class=\"data\">" . $episode['GroupName'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Codec'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Resolution'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Source'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Container'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Origin'] . "</td>\n";
			echo "<td class=\"data\">" . $episode['Category'] . "</td>\n";
			echo "</tr>";
	}
}
echo "</table>";

echo "<pre>";
//var_dump($results);

?>