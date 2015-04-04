# php-lol-api
A simple league of legends api


You need edit "examples/config.php" api key ([Get your api key here](https://developer.riotgames.com/)) and region code.


Example:
    
    <?php
    require('../lol.api.php');
    $summoner='carlos1705860015';
    $lol=new LeagueOfLegends('YOUR-API-KEY','euw');
    
    var_dump($lol->getSummonerByName($summoner));
    
    ?>

