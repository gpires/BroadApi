<?php

include('config.php'); 
include('header.php'); 


function sortRows($data)
{
	$size = count($data);

	for ($i = 0; $i < $size; ++$i) {
		$row_num = findSmallest($i, $size, $data);
		$tmp = $data[$row_num];
		$data[$row_num] = $data[$i];
		$data[$i] = $tmp;
	}

	return ( $data );
}

function findSmallest($i, $end, $data)
{
	$min['pos'] = $i;
	$min['value'] = $data[$i]['data'];
	$min['dir'] = $data[$i]['dir'];
	for (; $i < $end; ++$i) {
		if ($data[$i]['dir']) {
			if ($min['dir']) {
				if ($data[$i]['data'] < $min['value']) {
					$min['value'] = $data[$i]['data'];
					$min['dir'] = $data[$i]['dir'];
					$min['pos'] = $i;
				}
			} else {
				$min['value'] = $data[$i]['data'];
				$min['dir'] = $data[$i]['dir'];
				$min['pos'] = $i;
			}
		} else {
			if (!$min['dir'] && $data[$i]['data'] < $min['value']) {
				$min['value'] = $data[$i]['data'];
				$min['dir'] = $data[$i]['dir'];
				$min['pos'] = $i;
			}
		}
	}
	return ( $min['pos'] );
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
     $bytes /= pow(1024, $pow);
    
	return round($bytes, $precision) . ' ' . $units[$pow]; 
}

	$self = $_SERVER['PHP_SELF'];
	if (isset($_GET['dir'])) {
		$dir = $_GET['dir'];
		$size = strlen($dir);
		while ($dir[$size - 1] == '/') {
			$dir = substr($dir, 0, $size - 1);
			$size = strlen($dir);
		}
	} else {
		$dir = "../downloads/";
		$size = strlen($dir);
		while ($dir[$size - 1] != '/') {
			$dir = substr($dir, 0, $size - 1);
			$size = strlen($dir);
		}
		$dir = substr($dir, 0, $size - 1);
	}

?>
<div id="wrapper">
<?php include('menu.php'); ?>
	<div id="rightContent">
	<h3>Downloads</h3>


<?php

		if ($handle = opendir($dir)) {
			$size_document_root = strlen($_SERVER['DOCUMENT_ROOT']);
			$pos = strrpos($dir, "/");
			$topdir = substr($dir, 0, $pos + 1);
			$i = 0;
  	  		while (false !== ($file = readdir($handle))) {
        		if ($file != "." && $file != "..") {
					$rows[$i]['data'] = $file;
					$rows[$i]['dir'] = is_dir($dir . "/" . $file);
					$i++;
				}
			}
    		closedir($handle);
		}
		
		$size = count($rows);
		$rows = sortRows($rows);
?>		
		<table class="data">
		<tr class="data">
			<th class="data">#</th>
			<th class="data">Name</th>
			<th class="data">Size</th>
		</tr>	

<?php		
		for ($i = 0; $i < $size; ++$i) {
			$topdir = $dir . "/" . $rows[$i]['data'];
			
			echo "<tr>";
			echo "<td>";
			if ($rows[$i]['dir']) {
				echo "[DIR]";
				$file_type = "dir";
			} else {
				echo "[FILE]";
				$file_type = "file";
			}
			echo "</td>";
			echo "<td>    ";
        	echo "<a href='?dir=", $topdir, "'>", $rows[$i]['data'], "</a>\n";
			echo "</td>";
            echo "<td>";
            echo formatBytes(filesize($topdir));
            echo "</td>";
			echo "</tr>";
        }

?>
</table>
</div>

<?php include('footer.php'); ?>
</div>
</body>
</html>
