<?php
// Q3 Colours PHP Function
// M S Hughes

$colour["0"] = "000000";
$colour["1"] = "DA0120";
$colour["2"] = "00B906";
$colour["3"] = "E8FF19";
$colour["4"] = "170BDB";
$colour["5"] = "23C2C6";
$colour["6"] = "E201DB";
$colour["7"] = "AAA";
$colour["8"] = "CA7C27";
$colour["9"] = "757575";
$colour["a"] = "EB9F53";
$colour["b"] = "106F59";
$colour["c"] = "5A134F";
$colour["d"] = "035AFF";
$colour["e"] = "681EA7";
$colour["f"] = "5097C1";
$colour["g"] = "BEDAC4";
$colour["h"] = "024D2C";
$colour["i"] = "7D081B";
$colour["j"] = "90243E";
$colour["k"] = "743313";
$colour["l"] = "A7905E";
$colour["m"] = "555C26";
$colour["n"] = "AEAC97";
$colour["o"] = "C0BF7F";
$colour["p"] = "000000";
$colour["q"] = "DA0120";
$colour["r"] = "00B906";
$colour["s"] = "E8FF19";
$colour["t"] = "170BDB";
$colour["u"] = "23C2C6";
$colour["v"] = "E201DB";
$colour["w"] = "FFFFFF";
$colour["x"] = "CA7C27";
$colour["y"] = "757575";
$colour["z"] = "CC8034";
$colour["/"] = "DBDF70";
$colour["*"] = "BBBBBB";
$colour["-"] = "747228";
$colour["+"] = "993400";
$colour["?"] = "670504";
$colour["@"] = "623307";

function aq3cols($text){
	global $colour;
	$split	=	explode("^",$text);
	
	$col	=	array();
	$first	=	0;
	foreach($split as $split){
		if($first == 0){ 
			$first = 1;
			$out[] = $split;
		}
		else{
		if(isset($split[0])) $col = $split[0];
		$split	=	substr($split,1);
		if(count($col) > 0) $col = $colour[$col];
		$colline	=	"<font color=\"#$col\">$split</font>";
		
		$out[]	=	$colline;
		}
	}
	$out	=	implode("",$out);
	return $out;
}

function q3cols($text){
	global $colour;
	
	$opened	=	0;
	foreach($colour as $id => $hex){
		$opened	=	$opened+substr_count($text, "^".$id);
		$text	=	str_replace("^".$id, "<font color=\"#".$hex."\">", $text);
	}
	for ($i = 1; $i <= $opened; $i++) {
		$text	=	$text."</font>";
	}
	return $text;
}
