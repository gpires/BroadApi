<?php
error_reporting(0);
require("config.php");
require("class/jsonRPCClient.php");
require("class/TransmissionRPC.class.php");
require("class/PushBullet.class.php");

function allowedFilter($release_name) {
	$filtered = array("INTERNAL"); //add more filters here
	
	foreach($filtered as $filter)
		if(strpos($release_name, $filter) !== false)
			return false;
	return true;
}

function getTorrentSeasonEpisode($torrent, &$season_num, &$episode_num) {
	$season_num = (int)substr($torrent["GroupName"], 1, 2);
	$episode_num = (int)substr($torrent["GroupName"], 4, 5);
}

function checkIfDownload($torrent, $serie_params, $serie_episodes) {
	// Check if episode and season is valid
	$season_num;
	$episode_num;
	getTorrentSeasonEpisode($torrent, $season_num, $episode_num);
	$validEpisode = is_numeric($season_num) && is_numeric($episode_num)
				&& $season_num != 0 && $episode_num != 0;

	// Check if it hasnt been downloaded yet
	$isDownloaded = false;
	foreach($serie_episodes as $ep) {
		if($season_num == $ep["season"] && $episode_num == $ep["ep"])
			$isDownloaded = true;
	}
	
	// Check if params are correct
	$validParams = ($torrent["Codec"] == $serie_params["codec"])
				&& ($torrent["Resolution"] == $serie_params["resolution"])
				&& ($torrent["Source"] == $serie_params["source"])
				&& ($torrent["Container"] == $serie_params["container"])
				&& ($torrent["Origin"] == $serie_params["origin"])
				&& ($torrent["Category"] == $serie_params["category"]);
				
	return $validEpisode
			&& allowedFilter($torrent["ReleaseName"])
			&& $validParams
			&& !$isDownloaded;
}

function getSerieParams($serie_name) {
	global $con;
	
	$serie_name = mysqli_real_escape_string($con, $serie_name);   // Avoid Strange names 
	$serie_search = mysqli_query($con, "SELECT * FROM series WHERE name='$serie_name'");
	return mysqli_fetch_assoc($serie_search);
}

function getDownloadedSeriesEpisodes() {
	global $con;

	$downloaded_search = mysqli_query($con, "SELECT series.name, episodes.season, episodes.ep FROM episodes RIGHT OUTER JOIN series ON episodes.serie_id=series.id WHERE series.enabled=1");
	$downloaded_results = array();
	while($row = mysqli_fetch_array($downloaded_search)){
		$downloaded_results[$row["name"]][] = $row;
	}
	return $downloaded_results;
}

function getBTNLatestTorrents($btn) {
	global $btn_api_key, $btn_results;

	// Get BTN list
	$results;
	try {
		$results = $btn->getTorrents($btn_api_key, "", $btn_results);
	}
	catch(Exception $e) {
		// TODO: log do erro em vez deste echo
		//echo "api down";
		exit();
	}
	return $results["torrents"];
}

// Starts a new instance of each RPC client
$transmission = new TransmissionRPC($transmission_url, $transmission_user, $transmission_pass);
$btn = new jsonRPCClient($btn_api_url);

// Get latest BTN torrents
$latest = getBTNLatestTorrents($btn);

// Get downloaded episodes
$downloaded = getDownloadedSeriesEpisodes();

// Foreach torrent in btn's latest
foreach($latest as $torrentID => $torrent) {
	$serie_name = $torrent["Series"];
	
	// check if we want this serie
	if(array_key_exists($serie_name, $downloaded)) {
		// Get serie params
		$serie_params = getSerieParams($serie_name);
		$serie_episodes = $downloaded[$serie_name];
	
		// if the torrent params match our settings
		// and hasnt been downloaded, we want to download it
		if(checkIfDownload($torrent, $serie_params, $serie_episodes)) {
			$serie_id = $serie_params["id"];
			$season_num;
			$episode_num;
			getTorrentSeasonEpisode($torrent, $season_num, $episode_num);
		
			$result = $transmission->add($torrent["DownloadURL"]);
			//echo "<br><br>".$torrent["ReleaseName"]." - ".$season_num." - ".$episode_num."<br><br>";
			mysqli_query($con, "INSERT INTO episodes VALUES ($serie_id, $season_num, $episode_num)");
			
			// Log it !
			$msg_log = $torrent["ReleaseName"];
			mysqli_query($con, "INSERT INTO logs (id_msg,id_serie,msg_alt) VALUES ('1','$serie_id','$msg_log')");
		
			if ($pushb_api_active){
			$p = new PushBullet($pushb_api_key);
			$p->pushNote($pushb_channel, 'New Torrent', $msg_log);
			}
		}
	}
}
?>
