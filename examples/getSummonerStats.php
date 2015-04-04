<?php
require('./config.php');

$summoner=empty($_GET['summoner'])?'carlos1705860015':parseSummonerName($_GET['summoner']);

$summonerdata=$lol->getSummonerByName($summoner);

if(property_exists($summonerdata,'status'))
	exit(var_dump($summonerdata));

$stats=$lol->getSummonerStats($summonerdata->$summoner->id);

foreach($stats->playerStatSummaries as $v){
	echo '<br><br><br><br>'.$v->playerStatSummaryType.' ('.$v->wins.' wins)';
	foreach($v->aggregatedStats as $k2=>$v2)
		echo '<br>&nbsp;&nbsp;&nbsp;'.$k2.':&nbsp;&nbsp;'.$v2;
}

?>
