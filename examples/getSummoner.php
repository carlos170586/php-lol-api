<?php
require('./config.php');

$summoner=empty($_GET['summoner'])?'carlos1705860015':parseSummonerName($_GET['summoner']);

$summonerdata=$lol->getSummonerByName($summoner);

if(property_exists($summonerdata,'status'))
	exit(var_dump($summonerdata));

$SummonerID=$summonerdata->$summoner->id;
$SummonerName=$summonerdata->$summoner->name;

$masteries=$lol->getSummoner($SummonerID,'masteries');
$runes=$lol->getSummoner($SummonerID,'runes');

echo '<br>'.$SummonerName.' have '.count($masteries->$SummonerID->pages).' masteries pages and '.count($runes->$SummonerID->pages).' runes pages.';
?>
