<?php
require('../lol.api.php');

$lol=new LeagueOfLegends('YOUR-API-KEY','euw');

function parseSummonerName($name){
	return htmlspecialchars(trim(strtolower($name)));
}
?>
