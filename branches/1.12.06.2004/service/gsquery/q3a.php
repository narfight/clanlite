<?php

/*
 *  gsQuery - Querys various game servers
 *  Copyright (c) 2002-2004 Jeremias Reith <jr@terragate.net>
 *  http://gsquery.terragate.net
 *
 *  This file is part of the gsQuery library.
 *
 *  The gsQuery library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  The gsQuery library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with the gsQuery library; if not, write to the
 *  Free Software Foundation, Inc.,
 *  59 Temple Place, Suite 330, Boston,
 *  MA  02111-1307  USA
 *
 */

include_once("gsQuery.php");


/**
 * @brief Uses the Quake 3 protcol to communicate with the server
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: q3a.php,v 1.20 2004/05/17 05:46:39 jr Exp $
 *
 * This class can communicate with most games based on the Quake 3
 * engine.
 */
class q3a extends gsQuery
{

  function query_server($getPlayers=TRUE,$getRules=TRUE)
  { 
    $this->playerkeys=array();
    $this->debug=array();
    $this->password=-1;
      
    $command="\xFF\xFF\xFF\xFF\x02getstatus\x0a\x00";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      $this->errstr="No reply received";
      return FALSE;
    }
      
    $temp=explode("\x0a",$result);
    $rawdata=explode("\\",substr($temp[1],1,strlen($temp[1])));
    
    // get rules and basic infos
    for($i=0;$i< count($rawdata);$i++) {
      switch ($rawdata[$i++]) {
      case "g_gametypestring":
	$this->gametype=$rawdata[$i];
	break;
      case "gamename":
	$this->gametype=$rawdata[$i];
	
	$this->gamename="q3a_" . preg_replace("/[ ]/", "_", strtolower($rawdata[$i]));
	break;
      case "version":
	$this->gameversion=$rawdata[$i];
	break;
      // for CoD
      case "shortversion":
        $this->gameversion=$rawdata[$i];
        break; 
      case "sv_hostname":
	$this->servertitle=$rawdata[$i];
	break;
      case "mapname":
	$this->mapname=$rawdata[$i];
	break;
      case "g_needpass":
	$this->password=$rawdata[$i];
	break;
      // for CoD
      case "pswrd":
        $this->password=$rawdata[$i];
        break; 
      case "sv_maplist":
	$this->maplist=explode(" ", $rawdata[$i]);
	break;
      default:
	$this->rules[$rawdata[$i-1]] = $rawdata[$i];
      }
    }

    // for MoHAA
    if(!$this->gamename && eregi("Medal of Honor", $this->gameversion)) {
      $this->gamename="mohaa";
    }
    
    if(!empty($this->maplist)) {
      $i=0;
      while($this->mapname!=$this->maplist[$i++] && $i<count($this->maplist));
      $this->nextmap=$this->maplist[$i % count($this->maplist)];
    }
    
    //for MoHAA
    $this->mapname=preg_replace("/.*\//", "", $this->mapname);
    
    $this->hostport = $this->queryport;
    $this->maxplayers = $this->rules["sv_maxclients"]-$this->rules["sv_privateClients"];
    
    //get playerdata
    $temp=substr($result,strlen($temp[0])+strlen($temp[1])+1,strlen($result));
    $allplayers=explode("\n", $temp);
    $this->numplayers=count($allplayers)-2;
    
    // get players
    if(count($allplayers)-2 && $getPlayers) {
      for($i=1;$i< count($allplayers)-1;$i++) {
	// match with team info
	if(preg_match("/(\d+)[^0-9](\d+)[^0-9](\d+)[^0-9]\"(.*)\"/", $allplayers[$i], $curplayer)) {
	  if($curplayer[3]>2) {
	    next; // ignore spectators
	  }
	  $players[$i-1]["name"]=$curplayer[4];
	  $players[$i-1]["score"]=$curplayer[1];
	  $players[$i-1]["ping"]=$curplayer[2];	
	  $players[$i-1]["team"]=$curplayer[3];
	  $teamInfo=TRUE;
	  $pingOnly=FALSE;
	} elseif(preg_match("/(\d+)[^0-9](\d+)[^0-9]\"(.*)\"/", $allplayers[$i], $curplayer)) {
	  $players[$i-1]["name"]=$curplayer[3];
	  $players[$i-1]["score"]=$curplayer[1];
	  $players[$i-1]["ping"]=$curplayer[2];	
	  $pingOnly=FALSE;
	  $teamInfo=FALSE;
	}
	else {
	  if(preg_match("/(\d+).\"(.*)\"/", $allplayers[$i], $curplayer)) {
	    $players[$i-1]["name"]=$curplayer[2];
	    $players[$i-1]["ping"]=$curplayer[1];
	    $pingOnly=TRUE; // for MoHAA
	  }
	  else {
	    $this->errstr="Could not extract player infos!";
	    return FALSE;
	  }
	}
      }
      $this->playerkeys["name"]=TRUE;
      if(!$pingOnly) {
	$this->playerkeys["score"]=TRUE;
	if($teamInfo) {
	  $this->playerkeys["team"]=TRUE;
	}
      }
      $this->playerkeys["ping"]=TRUE;
      $this->players=$players;
    }
    
    return TRUE;
  }


  /**
   * @brief Sends a rcon command to the game server
   * 
   * @param command the command to send
   * @param rcon_pwd rcon password to authenticate with
   * @return the result of the command or FALSE on failure
   */
  function rcon_query_server($command, $rcon_pwd)
  {
    $command="\xFF\xFF\xFF\xFF\x02rcon ".$rcon_pwd." ".$command."\x0a\x00";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      $this->errstr="Error sending rcon command";
      return FALSE;
    } else {
      return $result;
    }
  } 

  /**
   * @brief htmlizes the given raw string
   *
   * @param var a raw string from the gameserver that might contain special chars
   * @return a html version of the given string
   */
  function htmlize($var) 
  {
    $var = htmlspecialchars($var);
    while(ereg('\^([0-9])', $var)) {
      foreach(array('black', 'red', 'darkgreen', 'yellow', 'blue', 'cyan', 'pink', 'white', 'blue-night', 'red-night') as $num_color => $name_color) {
	if (ereg('\^([0-9])(.*)\^([0-9])', $var)) {
	  $var = preg_replace("#\^".$num_color."(.*)\^([0-9])#Usi", "<span class=\"gsquery-".$name_color."\">$1</span>^$2", $var);
	} else {
	  $var = preg_replace("#\^".$num_color."(.*)$#Usi", "<span class=\"gsquery-".$name_color."\">$1</span>", $var);
	}
      }
    }
    return $var;
  }
}
?>
