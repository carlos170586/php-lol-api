<?php
require('./config.php');

$summoner=empty($_GET['summoner'])?'carlos1705860015':parseSummonerName($_GET['summoner']);

$summonerdata=$lol->getSummonerByName($summoner);

if(property_exists($summonerdata,'status'))
	exit(var_dump($summonerdata));

$SummonerID=$summonerdata->$summoner->id;
$SummonerName=$summonerdata->$summoner->name;

$teams=$lol->getTeams($SummonerID);

echo '<br>'.$SummonerName.' ('.count($teams->$SummonerID).') Teams:';
foreach($teams->$SummonerID as $v)
	echo '<br>['.$v->tag.'] '.$v->name;
?>
