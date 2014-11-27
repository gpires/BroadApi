<?php
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
     $bytes /= pow(1024, $pow);
    
	return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

function secondsToTime($seconds) {
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days');
}


function pagination($query,$per_page=10,$page=1,$url='?'){  
    global $con;
    $query = "SELECT COUNT(*) as `num` FROM {$query}";
    $row = mysqli_fetch_array(mysqli_query($con,$query));
    $total = $row['num'];
    $adjacents = "2";
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page); 
    $start = ($page - 1) * $per_page;                              
      
    $prev = $page - 1;                         
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){  
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){  
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                   
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                   
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>"; 
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                   
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";     
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                   
                }
            }
        }
          
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";       
    }
      
    return $pagination;
}

function statustorrent($intstatus) {
      if( $intstatus == 1 )
        return "Waiting to verify local files";
      if( $intstatus == 2 )
        return "Verifying local files";
      if( $intstatus == 4 )
        return "<font color=\"#DBA901\">Downloading</font>";
      if( $intstatus == 6 )
        return "<font color=\"green\">Seeding</font>";
      if( $intstatus == 0 )
        return "<font color=\"red\">Stopped</font>";
      if( $intstatus == 5 )
        return "Queued for seeding";
      if( $intstatus == 3 )
        return "Queued for download";
    }

function colorratio($ratio) {
	if( $ratio >= 1 )
		$color = '#006600';
	elseif( $ratio == 1 )
		$color = '#33FF00';
	elseif( $ratio >= 0.8 )
		$color = '#FF9900';
	elseif( $ratio >= 0.5 )
		$color = '#FF3300';
	elseif( $ratio >= 0 )
		$color = '#FF0000 ';
	
	return "<font color=\"$color\">$ratio</font>";
}	



function rateupload($rate) {
	if( $rate > 0 )
		return "<img src=\"mos-css/img/arrow_large_up.png\" title=\"".formatBytes($rate)."/s\">";
}	



?>