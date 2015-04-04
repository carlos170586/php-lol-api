<?php
require('./config.php');


$summoners=empty($_GET['summoner'])?array('carlos170586','carlos1705860015'):array_map('parseSummonerName',$_GET['summoner']);

$SummonerIDs=array();
$SummonerNames=array();
$summonerdata=$lol->getSummonerByName($summoners);

if(property_exists($summonerdata,'status'))
	exit(var_dump($summonerdata));

foreach($summonerdata as $v){
	$SummonerIDs[]=$v->id;
	$SummonerNames[$v->id]=$v->name;
}

$masteries=$lol->getSummoner($SummonerIDs,'masteries');
$runes=$lol->getSummoner($SummonerIDs,'runes');


foreach($SummonerIDs as $k=>$v)
	echo '<br>'.$SummonerNames[$v].' have '.count($masteries->$v->pages).' masteries pages and '.count($runes->$v->pages).' runes pages.';
?>
