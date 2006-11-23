<?php

/*
 *  gsQuery - Querys various game servers
 *  Copyright (c) 2004 Curtis Brown <webmaster@2dementia.com>
 *  Copyright (c) 2004 Jeremias Reith <jr@terragate.net>
 *  http://www.gsquery.org
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
 * @brief Uses the openQuery protcol to communicate with the server
 * @author Curtis Brown
 * 
 * The openQuery protocol comes from UDP Soft (creators of 'The All Seeing Eye')
 */
class openQuery extends gsQuery
{

  
  function query_server($getPlayers=TRUE,$getRules=TRUE)
  {
    $this->playerteams = array('red', 'blue');
    $this->playerkeys = array();
    $this->debug = array();
    $this->errstr = "";
    $this->password = -1;
    
    $cmd="s";
    if(!($response=$this->_sendCommand($this->address, $this->queryport, $cmd))) {
      $this->errstr="No reply received";
      return FALSE;
    }

    $players = explode("?",$response);
    $gamearray = array();
    $pos = 1;
    $gamearray[0] = substr($players[0],0,4);
    for($i=4;$i<strlen($players[0]);$i++) {
      $gamearray[$pos] = substr($players[0],$i+1,ord(substr($players[0],$i,1))-1);
      $i = $i + ord(substr($players[0],$i,1))-1;
      $pos = $pos + 1;
    }
    array_pop($gamearray); // \x01 is no rule 

    $this->numplayers=$gamearray[8];
    $this->maxplayers=$gamearray[9];
    $this->gametype=$gamearray[1];
    $this->gamename=$gamearray[1];
    $this->gameversion="1.1"; // Queries weren't supported before 1.1, version not supplied.
    $this->servertitle=$gamearray[3];
    $this->mapname=$gamearray[5];
    $this->hostport=$gamearray[2];
    $this->gametype=$gamearray[4];
    
    // get rules and basic infos
    for($i=10;$i<count($gamearray);$i++) {      
      switch ($gamearray[$i++]) {
      case "gr_NextMap":
	$this->nextmap=$gamearray[$i];
	break;
      default:
	$gamearray[$i-1]=$gamearray[$i-1]; 
	$this->rules[$gamearray[$i-1]] = $gamearray[$i];
      }
    }

    $this->_processPlayers($players);
    $this->online=TRUE;
    return TRUE;
  }


  /**
   * @internal 
   * @brief Extracts the players out of the given data
   *
   * @param rawPlayerData data with players
   * @return TRUE on success
   * @todo Add spectators
   */
  function _processPlayers($rawPlayerData)
  {
    $this->playerkeys["name"]=TRUE;
    $this->playerkeys["ping"]=TRUE;
    $this->playerkeys["score"]=TRUE;
    $this->playerkeys["time"]=TRUE;
    //$this->playerkeys["skin"]=TRUE; //no skin at the moment
    $this->playerkeys["team"]=TRUE;

    $numPlayers = 0;

    for ($i=1;$i<count($rawPlayerData);$i++) {
      $atmp = preg_split("/[\x01-\x1f]/", $rawPlayerData[$i]);      

      if($atmp[2] == 'spectators') {
	continue; // ignoring spectators for the moment
      } 

      $this->players[$numPlayers]["name"]=$atmp[1];
      //$this->players[$i]["skin"]=$atmp[3];
      $this->players[$numPlayers]["score"]=$atmp[4];
      $this->players[$numPlayers]["ping"]=$atmp[5];
      $this->players[$numPlayers]["time"]=$atmp[6];
      
      switch ($atmp[2]) {
      case "red":
	$this->players[$numPlayers]["team"]=1;
	break;
      case "blue":
	$this->players[$numPlayers]["team"]=2;
	break;
      case "players":
	// non team based play?
      default:
      }
      $numPlayers++;
    }
    return TRUE;
  }
  
  
  function htmlize($str) 
  {
    $colors = array("black", "white", "blue", "green", "red", "light-blue", "yellow", "pink", "orange", "grey");
    
    $str = htmlentities($str);
    $num_tags = preg_match_all("/\\$(\d)/", $str, $matches);
    $str = preg_replace("/\\$(\d)/e", "'<span class=\"gsquery-'. \$colors[\$1] .'\">'", $str);
    
    return $str . str_repeat("</span>", $num_tags);
  }


  function _getClassName()
  {
      return "openQuery";
  }
} 

?>
