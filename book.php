<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
<!--
<style>
body {
    background-color: yellow;
}
</style>
-->
</head>
<body>
	  <img width="100%" style="border-bottom: 12px solid #2d2d2d" src="header2.jpg">
    <img class="down" src="down.png">
        <div id="content">       
    
<?php
	$query = $_GET['search'];
	$url_par = parse_url($query);
	if ( $url_par['scheme'] == 'http') {
		$all_param = array();
		$query = $url_par['path'];
		$pieces = explode("-", $query);
		foreach($pieces as $k) {
			if (strlen($k) > 3) {
				if(!strstr($k, "html") &&  !strstr($k, "/")) {
					array_push($all_param,$k);
				}
			}
		}
//		print_r($all_param);
		$query = implode(' ',$all_param);

	}
	

	$url = "https://www.googleapis.com/customsearch/v1?key=xxxxx&cx=017168567045374273369:-g6vlztkxdo&q=" . urlencode($query);

//	echo $url;

	function getSslPage($url) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_REFERER, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}

	$body = getSslPage($url);
	$json = json_decode($body);

//	print_r($body);
//	print_r($json->items);
	//print_r($json->items[1]->link);
	//echo count($json->items);

	for($x=0;$x<count($json->items)-1;$x++){

		//echo "<br>";
		echo "<div id='sidebar'>";
		echo "<img class='roundedImage' src='" . $json->items[$x]->pagemap->cse_thumbnail[0]->src . "'>";
		echo "</div>";
		//echo "<a href="$json->items[$x]->link;
		echo "<div id='main-content'>";
		echo "<a target='_blank' href='" . $json->items[$x]->link . "'>" . utf8_decode($json->items[$x]->title) . "</a>";
		echo "<div class='intro'>" . utf8_decode($json->items[$x]->snippet). "</div>";
		echo "</div><br/>";

//		echo "<br/>";

	}
?>
</div>
</body>
</html>