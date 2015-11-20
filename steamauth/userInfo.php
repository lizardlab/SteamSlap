<?php

require_once('db.php');

    if(!$_SESSION['steamid'] == ""){
    	include("settings.php");
        if (empty($_SESSION['steam_uptodate']) or $_SESSION['steam_uptodate'] == false or empty($_SESSION['steam_personaname'])) {
            @ $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
            $content = json_decode($url, true);
            $_SESSION['steam_steamid'] = $content['response']['players'][0]['steamid'];
            $_SESSION['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
            $_SESSION['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
            $_SESSION['steam_personaname'] = $content['response']['players'][0]['personaname'];
            $_SESSION['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
            $_SESSION['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
            $_SESSION['steam_avatar'] = $content['response']['players'][0]['avatar'];
            $_SESSION['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
            $_SESSION['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
            $_SESSION['steam_personastate'] = $content['response']['players'][0]['personastate'];
            if (isset($content['response']['players'][0]['realname'])) { 
    	           $_SESSION['steam_realname'] = $content['response']['players'][0]['realname'];
    	       } else {
    	           $_SESSION['steam_realname'] = "Real name not given";
            }
            $_SESSION['steam_primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
            $_SESSION['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
            $_SESSION['steam_uptodate'] = true;
        }
        $steamprofile['steamid'] = $_SESSION['steam_steamid'];
        $steamprofile['communityvisibilitystate'] = $_SESSION['steam_communityvisibilitystate'];
        $steamprofile['profilestate'] = $_SESSION['steam_profilestate'];
        $steamprofile['personaname'] = $_SESSION['steam_personaname'];
        $steamprofile['lastlogoff'] = $_SESSION['steam_lastlogoff'];
        $steamprofile['profileurl'] = $_SESSION['steam_profileurl'];
        $steamprofile['avatar'] = $_SESSION['steam_avatar'];
        $steamprofile['avatarmedium'] = $_SESSION['steam_avatarmedium'];
        $steamprofile['avatarfull'] = $_SESSION['steam_avatarfull'];
        $steamprofile['personastate'] = $_SESSION['steam_personastate'];
        $steamprofile['realname'] = $_SESSION['steam_realname'];
        $steamprofile['primaryclanid'] = $_SESSION['steam_primaryclanid'];
        $steamprofile['timecreated'] = $_SESSION['steam_timecreated'];
	
	$id = $steamprofile['steamid'];
	$name = $steamprofile['personaname'];
	$avatar = $steamprofile['avatarfull'];
	try{
	$check = $db->query("SELECT * FROM users WHERE sid='$id'");
	} catch (PDOException $e) {

        echo $e->getMessage();
	die();
        }
	
	$isgood = $check->fetch(PDO::FETCH_NUM);

	if($isgood[0]>=1)
	{
	
	}
	else
	{
	try{
	$newUser->bindValue(':sid', $id, PDO::PARAM_STR);
	$newUser->bindValue(':name', $name, PDO::PARAM_STR);
	$newUser->bindValue(':avatar', $avatar, PDO::PARAM_STR);
	$newUser->execute();

	} catch (PDOException $e) {

	echo $e->getMessage();

	}
	}
    }
?>
    
