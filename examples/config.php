<?php
require('../lol.api.php');

$lol=new LeagueOfLegends('YOUR-API-KEY','euw');

function parseSummonerName($name){
	return htmlspecialchars(mb_strtolower(str_replace(" ", "",$name), 'UTF-8'));
}
?>
