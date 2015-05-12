<?php
/*
 *
 *	LeagueOfLegends API
 *	By [EUW] carlos1705860015
 *	https://github.com/carlos170586
 *
*/

class LeagueOfLegends{
	private $api_key;
	public $region;
	public $returnJSON;
	public $platforms=array(
		'na'=>'NA1',
		'br'=>'BR1',
		'lan'=>'LA1',
		'las'=>'LA2',
		'oce'=>'OC1',
		'eune'=>'EUN1',
		'tr'=>'TR1',
		'ru'=>'RU',
		'euw'=>'EUW1',
		'kr'=>'KR',
		'pbe'=>'PBE1'
	);

	function __construct($key,$region,$returnJSON=false){
		$this->api_key=trim($key);
		$this->region=trim(strtolower($region));
		$this->returnJSON=$returnJSON;
	}


	public function getSummonerByName($Name){
	/*	Get summoner objects mapped by standardized summoner name for a given list of summoner names	*/
		return $this->getData($this->getDataUrl('summoner/by-name/'.(is_array($Name)?implode(',',$Name):$Name),'1.4'));
	}

	public function getSummoner($SummonerID,$page=''){
	/*	Get summoner objects mapped by summoner ID for a given list of summoner IDs
		(string)		$page		=['','masteries','runes','name']
	*/
		return $this->getData($this->getDataUrl('summoner/'.(is_array($SummonerID)?implode(',',$SummonerID):$SummonerID).'/'.$page,'1.4'));
	}

	public function getSummonerStats($SummonerID,$isRanked=false,$season=false){
	/*	Get player stats by summoner ID	*/
		return $this->getData($this->getDataUrl('stats/by-summoner/'.$SummonerID.'/'.($isRanked?'ranked':'summary'),'1.3',$season?array('season'=>$season):array()));
	}

	public function getTeams($SummonerID){
	/*	Get teams mapped by summoner ID for a given list of summoner IDs	*/
		return $this->getData($this->getDataUrl('team/by-summoner/'.(is_array($SummonerID)?implode(',',$SummonerID):$SummonerID),'2.4'));
	}

	public function getTeamInfo($TeamID){
	/*	Get teams mapped by team ID for a given list of team IDs	*/
		return $this->getData($this->getDataUrl('team/'.(is_array($TeamID)?implode(',',$TeamID):$TeamID),'2.4'));
	}

	public function getLeagues($SummonerID,$entry=false){
	/*	Get leagues mapped by Summoner ID for a given list of IDs	*/
		return $this->getData($this->getDataUrl('league/by-summoner/'.(is_array($SummonerID)?implode(',',$SummonerID):$SummonerID).'/'.($entry?'entry':''),'2.5'));
	}

	public function getLeaguesByTeam($TeamID,$entry=false){
	/*	Get leagues mapped by team ID for a given list of IDs	*/
		return $this->getData($this->getDataUrl('league/by-team/'.(is_array($TeamID)?implode(',',$TeamID):$TeamID).'/'.($entry?'entry':''),'2.5'));
	}

	public function getChallengerLeague($params=array('type'=>'RANKED_SOLO_5x5')){
	/*	Get challenger tier leagues	*/
		return $this->getData($this->getDataUrl('league/challenger/','2.5',$params));
	}

	public function getRecentGames($SummonerID) {
	/*	Get recent games by summoner ID	*/
		return $this->getData($this->getDataUrl('game/by-summoner/'.$SummonerID.'/recent','1.3'));
	}

	public function getMatchHistory($SummonerID,$params=array()) {
	/*	Retrieve match history by summoner ID
		({string})		$params=[
							'championIds'	=>		Champion IDs separed by comma
							'rankedQueues'	=>		[RANKED_SOLO_5x5,RANKED_TEAM_5x5,RANKED_TEAM_3x3]
							'beginIndex'
							'endIndex'
						]
	*/
		return $this->getData($this->getDataUrl('matchhistory/'.$SummonerID,'2.2',$params));
	}

	public function getMatch($MatchID,$Timeline=false) {
	/*	Retrieve match by match ID	*/
		return $this->getData($this->getDataUrl('matchhistory/'.$MatchID,'2.2',$Timeline?array('includeTimeline'=>1):array()));
	}

	public function getCurrentGame($id){
	/*	Get current game information for the given summoner ID
		No idea about platform ids ( https://developer.riotgames.com/docs/spectating-games )
	*/
		return $this->getData($this->getObserverUrl('consumer/getSpectatorGameInfo/'.$this->platforms[$this->region].'/'.$id,array()));
	}

	public function getFeaturedGames(){
	/*	Get list of featured games	*/
		return $this->getData($this->getObserverUrl('featured'));
	}




	public function getChampionData($ChampionID=''){
	/*	Retrieve (all champions /a champion by id) Data	*/
		return $this->getData($this->getDataUrl('champion/'.$ChampionID,'1.2'));
	}

	public function getShards($Region=false){
	/*	Get shard status. Returns the data available on the status.leagueoflegends.com website for the given region	*/
		return $this->getData($this->getShardsUrl($Region));
	}


	public function getStaticData($page,$params=array()){
	/*	Retrieves Static data	*/
		return $this->getData($this->getStaticUrl($page,'1.2',$params));
	}



	public function getShardsUrl($data=false){
		return 'http://status.leagueoflegends.com/shards'.($data?'/'.$data:'');
	}
	public function getStaticUrl($data,$version,$params=array()){
		return 'https://global.api.pvp.net/api/lol/static-data/'.$this->region.'/v'.$version.'/'.$data.'?'.http_build_query(array_merge(array('api_key'=>$this->api_key),$params));
	}
	public function getObserverUrl($data,$params=array()){
		return 'https://'.$this->region.'.api.pvp.net/observer-mode/rest/'.$data.'?'.http_build_query(array_merge(array('api_key'=>$this->api_key),$params));
	}
	public function getDataUrl($data,$version,$params=array()){
		return 'https://'.$this->region.'.api.pvp.net/api/lol/'.$this->region.'/v'.$version.'/'.$data.'?'.http_build_query(array_merge(array('api_key'=>$this->api_key),$params));
	}

	public function getData($url){
		$ch=curl_init($url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		$r=curl_exec($ch);
		curl_close($ch);
		
		return $this->returnJSON?$r:json_decode($r);
	}

	public function gotResponse($r){
		return !$r || !empty($r->status) && $r->status!="200"?false:true;
	}
	
	static function parseSummonerName($name){
		return htmlspecialchars(mb_strtolower(str_replace(" ", "",$name), 'UTF-8'));
	}
}
?>