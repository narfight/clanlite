<?php

/*
 *  gsQuery - Querys game servers
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
 * @brief Querys a halflife server
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: hlife.php,v 1.11 2004/05/22 17:01:39 jr Exp $
 * @bug negative scores are not shown correctly 
 * @todo extract time field out of the player data

 * Code is very ugly at the moment.
 * Does anyone have the protocol specs?<br>
 *
 * This class works with Halflife only. 
 */
class hlife extends gsQuery
{
  function getGameJoinerURI()
  {
    return "gamejoin://hlife@". $this->address .":". $this->hostport ."/". $this->gametype;
  }

  function query_server($protocol="gsqp",$getPlayers=TRUE,$getRules=TRUE)
  {      
    $this->playerkeys=array();
    $this->debug=array();
    $this->password=-1;
            
    $command="\xFF\xFF\xFF\xFFinfostring\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      return FALSE;
    }
    
    $exploded_data = explode("\\", $result);
    for($i=1;$i<count($exploded_data);$i++) {
      switch($exploded_data[$i++]) {
      case "address":
	list($ip, $this->hostport) = explode(":", $exploded_data[$i]);
	break;
      case "hostname":
	$this->servertitle = $exploded_data[$i];
	break;
      case "map":
	$this->mapname = $exploded_data[$i];
	break;
      case "players":
	$this->numplayers = $exploded_data[$i];
	break;
      case "max":
	$this->maxplayers = $exploded_data[$i];
	break;
      case "protocol":
	$this->gameversion = ($exploded_data[$i] == 47)? '1.6' : '1.5';
	break;
      case "gamedir":
	$this->gamename = "hlife_" . $exploded_data[$i];
	$this->gametype = $exploded_data[$i];
	break;
      }
    } 
	$this->gametype = ($this->gametype == 'cstrike')? $this->gametype.' '.$this->gameversion : $this->gametype;
    
    // get players
    if($this->numplayers && $getPlayers) {
      $command="\xFF\xFF\xFF\xFFplayers\n";
      if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
	return FALSE;
      }
      
      $exploded_data = explode("\x00", substr($result, 4, strlen($result)));
      $players[0]["name"]=substr($exploded_data[0], 3, strlen($exploded_data[0]));
      $players[0]["score"]=hexdec(bin2hex(substr($exploded_data[1],0,1))); 
      // correction to signed short (is there a better way in PHP to do that?)
      if($players[0]["score"]>128) {
	$players[0]["score"]-=256;
      }
      
      for($i=1;$i<count($exploded_data);$i++) {
	if(strlen($exploded_data[$i])>4) {
	  $players[$i]["name"]=substr($exploded_data[$i], 5, strlen($exploded_data[$i]));
	  $players[$i]["score"]=hexdec(bin2hex(substr($exploded_data[$i+1],0,1)));
	}
      }
      $this->playerkeys["name"]=TRUE;
      $this->playerkeys["score"]=TRUE;
      $this->players=$players;
    }
    
    // get rules
    $command="\xFF\xFF\xFF\xFFrules\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      return FALSE;
    }
    
    $exploded_data = explode("\x00", $result);
    $this->password = -1;

    for($i=1;$i<count($exploded_data);$i++) {
      switch($exploded_data[$i++]) {
      case "sv_password":
	$this->password=$exploded_data[$i];
	break;
      case "amx_nextmap":
	$this->nextmap=$exploded_data[$i];
	break;
      case "cm_nextmap":
	$this->nextmap=$exploded_data[$i];
	break;
      default:
	if(isset($exploded_data[$i-1]) && isset($exploded_data[$i])) {
	  $this->rules[$exploded_data[$i-1]]=$exploded_data[$i];
	}
      }
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
    $get_challenge="\xFF\xFF\xFF\xFFchallenge rcon\n";
    if(!($challenge_rcon=$this->_sendCommand($this->address,$this->queryport,$get_challenge))) {
      $this->debug["Command send " . $command]="No challenge rcon received";
      return FALSE;
    }
    if (!ereg('challenge rcon ([0-9]+)', $challenge_rcon)) {
      $this->debug["Command send " . $command]="No valid challenge rcon received";
      return FALSE;
    }
    $challenge_rcon=substr($challenge_rcon, 19,10);
    $command="\xFF\xFF\xFF\xFFrcon \"".$challenge_rcon."\" ".$rcon_psw." ".$command."\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      $this->debug["Command send " . $command]="No reply received";
      return FALSE;
    } else {
      return substr($result, 5);
    }
  }
}

?>
