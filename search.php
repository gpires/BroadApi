<?php 
include('config.php'); 
include('header.php'); 

?>

<div id="wrapper">
<?php include('menu.php'); ?>
	<div id="rightContent">
	<h3>Search</h3>
	
		<table width="95%">
			<form name="frm" method="POST" action="">
			<tr><td width="125px"><b>Name</b></td><td><input type="text" id="name" class="pendek"></td></tr>
			<tr><td><b>Codec</b></td><td>
				<select id="codec">
					<option value ="" selected>-- codec --</option>
					<option value="XViD" >XViD</option>
                    <option value="x264" >x264</option>
                    <option value="MPEG2" >MPEG2</option>
                    <option value="DiVX" >DiVX</option>
                    <option value="DVDR" >DVDR</option>
                    <option value="VC-1" >VC-1</option>
                    <option value="h.264" >h.264</option>
                    <option value="WMV" >WMV</option>
                    <option value="BD" >BD</option>
                    <option value="x264-Hi10P" >x264-Hi10P</option>
				</select>
			</td></tr>
			
			<tr><td><b>Resolution</b></td><td>
				<select id="resolution">
					<option value ="" selected>-- resolution --</option>
                    <option value="SD" >SD</option>
                    <option value="720p" >720p</option>
                    <option value="1080p" >1080p</option>
                    <option value="1080i" >1080i</option>
                    <option value="Portable Device" >Portable Device</option>
				</select>
			</td></tr>
			
			<tr><td><b>Source</b></td><td>
				<select id="source">
					<option value ="" selected>-- source --</option>
                    <option value="HDTV" >HDTV</option>
                    <option value="PDTV" >PDTV</option>
                    <option value="DSR" >DSR</option>
                    <option value="DVDRip" >DVDRip</option>
                    <option value="TVRip" >TVRip</option>
                    <option value="VHSRip" >VHSRip</option>
                    <option value="Bluray" >Bluray</option>
                    <option value="BDRip" >BDRip</option>
                    <option value="BRRip" >BRRip</option>
                    <option value="DVD5" >DVD5</option>
                    <option value="DVD9" >DVD9</option>
                    <option value="HDDVD" >HDDVD</option>
                    <option value="WEB-DL" >WEB-DL</option>
                    <option value="WEBRip" >WEBRip</option>
                    <option value="BD5" >BD5</option>
                    <option value="BD9" >BD9</option>
                    <option value="BD25" >BD25</option>
                    <option value="BD50" >BD50</option>
                    <option value="Mixed" >Mixed</option>
                    <option value="Unknown" >Unknown</option>
				</select>
			</td></tr>
			
			<tr><td><b>Container</b></td><td>
				<select id="container">
					<option value ="" selected>-- container --</option>
                    <option value="AVI" >AVI</option>
                    <option value="MKV" >MKV</option>
                    <option value="VOB" >VOB</option>
                    <option value="MPEG" >MPEG</option>
                    <option value="MP4" >MP4</option>
                    <option value="ISO" >ISO</option>
                    <option value="WMV" >WMV</option>
                    <option value="TS" >TS</option>
                    <option value="M4V" >M4V</option>
                    <option value="M2TS" >M2TS</option>
				</select>
			</td></tr>
			
			<tr><td><b>Origin</b></td><td>
				<select id="origin">
					<option value ="" selected>-- origin --</option>
                    <option value="None" >None</option>
                    <option value="Scene" >Scene</option>
                    <option value="P2P" >P2P</option>
                    <option value="User" >User</option>
                    <option value="Mixed" >Mixed</option>
                    <option value="Internal" >Internal</option>
				</select>
			</td></tr>
			
			<tr><td><b>Category</b></td><td>
				<select id="category">
					<option value ="" selected>-- category --</option>
                    <option value="Episode" >Episode</option>
                    <option value="Season" >Season</option>
				</select>
			</td></tr>
			
			<tr><td></td><td>
			<input type="submit" class="button" id="Search" value="Submit">
			<input type="reset" class="button" value="Reset">
			</td></tr>
		</form>
		</table>

<script>
$("#Search").click(function(e) {
  e.preventDefault();
  var name = $("#name").val(); 
  var codec = $("#codec option:selected").val();
  var resolution = $("#resolution option:selected").val();
  var source = $("#source option:selected").val();
  var container = $("#container option:selected").val();
  var origin = $("#origin option:selected").val();  
  var category = $("#category option:selected").val();
  var dataString = 'name='+name+'&codec='+codec+'&resolution='+resolution+'&source='+source+'&container='+container+'&origin='+origin+'&category='+category;
  $.ajax({
    type:'POST',
    data:dataString,
    url:'search_post.php',
    success:function(data) {
      $( "#rightContent" ).append(data);
    }
  });
});		
</script>
</div>

<?php include('footer.php'); ?>
</div>
</body>
</html>