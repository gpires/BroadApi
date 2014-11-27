<?php error_reporting(0);
include('config.php'); 
include('header.php');
include('class/functions.php'); 
require_once('class/TransmissionRPC.class.php');

$RPC = new TransmissionRPC($transmission_url,$transmission_user,$transmission_pass);
$result = $RPC->sstats( );

$fields_get = array("id","name","uploadRatio","totalSize","status","rateUpload");
$torrent_list_get = $RPC->get(array(),$fields_get);
$torrent_list = $torrent_list_get->arguments->torrents;

$activeT = $result->arguments->activeTorrentCount;
$numberT = $result->arguments->torrentCount;
$uploadS = $result->arguments->uploadSpeed;
$downloadS = $result->arguments->downloadSpeed;

$totalDownload = $result->arguments->cumulative_stats->downloadedBytes;
$totalUpload = $result->arguments->cumulative_stats->uploadedBytes;
$sessionCount = $result->arguments->cumulative_stats->sessionCount;
$sessionTime = $result->arguments->cumulative_stats->secondsActive;

?>

<div id="wrapper">
<?php include('menu.php'); ?>
	<div id="rightContent">
	<h3>Home</h3>

		<div class="clear"></div>
		
		<div id="smallRight"><h3>Transmission Information</h3>
		<table style="border: none;font-size: 12px;color: #5b5b5b;width: 100%;margin: 10px 0 10px 0;">
			<tr><td style="border: none;padding: 4px;">Active Torrents:</td><td style="border: none;padding: 4px;"><b><?php echo $activeT; ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Total Torrents:</td><td style="border: none;padding: 4px;"><b><?php echo $numberT; ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Upload Speed</td><td style="border: none;padding: 4px;"><b><?php echo formatBytes($uploadS)."/s"; ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Download Speed</td><td style="border: none;padding: 4px;"><b><?php echo formatBytes($downloadS)."/s"; ?></b></td></tr>
		</table>
		</div>
		<div id="smallRight"><h3>Statistics</h3>
		
		<table style="border: none;font-size: 12px;color: #5b5b5b;width: 100%;margin: 10px 0 10px 0;">
			<tr><td style="border: none;padding: 4px;">Total Download</td><td style="border: none;padding: 4px;"><b><?php echo formatBytes($totalDownload); ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Total Upload</td><td style="border: none;padding: 4px;"><b><?php echo formatBytes($totalUpload); ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Times Started</td><td style="border: none;padding: 4px;"><b><?php echo $sessionCount; ?></b></td></tr>
			<tr><td style="border: none;padding: 4px;">Running Time</td><td style="border: none;padding: 4px;"><b><?php echo secondsToTime($sessionTime); ?></b></td></tr>
		</table>
		</div>
	
	
	<h3>Downloading Torrents</h3>
	<table class="data">
		<tr class="data">
			<th class="data">Name</th>
			<th class="data">Size</th>
		</tr>
<?
foreach($torrent_list as $id => $torrents) {
	if ($torrents->status == 4){
		echo "<tr class=\"data\">";
		echo "<td class=\"data\">" . $torrents->name . "</td>\n";
		echo "<td class=\"data\">" . formatBytes($torrents->totalSize) . "</td>\n";
		echo "</tr>";
	}
}
echo "</table>";
?>	
	<br>
	<h3>Complete Torrents</h3>
	<table class="data">
		<tr class="data">
			<th class="data">Name</th>
			<th class="data">Status</th>
			<th class="data">Size</th>
			<th class="data">Ratio</th>
		</tr>
<?
foreach($torrent_list as $id => $torrents) {
		echo "<tr class=\"data\">";
		echo "<td class=\"data\">" . $torrents->name . " ".rateupload($torrents->rateUpload)."</td>\n";
		echo "<td class=\"data\">" .statustorrent($torrents->status) ."</td>\n";
		echo "<td class=\"data\">" . formatBytes($torrents->totalSize) . "</td>\n";
		echo "<td class=\"data\">" . colorratio($torrents->uploadRatio) . "</td>\n";
		echo "</tr>";
	}
echo "</table>";
?>		

</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>