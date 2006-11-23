<?php

/*
 *  gsQuery - Querys game servers
 *  Copyright (c) 2003 Jeremias Reith <jr@terragate.net>
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

include_once("gameSpy.php");

/**
 * @brief Extends the gameSpy protocol to support America's Army
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: armyGame.php,v 1.3 2003/08/21 17:50:00 jr Exp $
 *
 * This is a quick hack to support the changed America's Army protocol.
 * It is slow, incomplete and ugly. Does anyone have the protocol specs?
 * @todo Add rules & clean up
 */
class armyGame extends gameSpy
{

  function query_server($getPlayers=TRUE,$getRules=TRUE)
  {       
    $this->playerkeys=array();
    $this->debug=array();
    $this->errstr="";
    $this->password=-1;
    
    $command="\\status\\";
    if(!($result=$this->_sendCommand($this->address, $this->queryport, $command))) {
      $this->errstr="No reply recieved";
      return FALSE;
    }

    // xxx: not a nice way 
    ereg("^(.*)(\\\\player_0.*)$", $result, $matches);
    // get rid of the team scores
    $matches[2]=preg_replace("/\\\score_t\d.\d/e", "", $matches[2]);

    $this->_processServerInfo($matches[1]); 
    $this->_processPlayers($matches[2]);   

    return TRUE;
  }  

  function sortPlayers($players, $sortkey="name") 
  {
    if(!sizeof($players)) {
      return array();
    }
    switch($sortkey) {
    case "roe":
      uasort($players, array("armyGame", "_sortbyRoe"));
      break;
    case "kia":
      uasort($players, array("armyGame", "_sortbyKia"));
      break;
    case "enemy":
      uasort($players, array("armyGame", "_sortbyEnemy"));
      break;
    default:
      $players=parent::sortPlayers($players, $sortkey);
    }
    return ($players);
  }


  // private methods

  function _sortbyRoe($a, $b) 
  {
    if($a["roe"]==$b["roe"]) { return 0; } 
    elseif($a["roe"]<$b["roe"]) { return 1; }
    else { return -1; }
  }

  function _sortbyKia($a, $b) 
  {
    if($a["kia"]==$b["kia"]) { return 0; } 
    elseif($a["kia"]<$b["kia"]) { return 1; }
    else { return -1; }
  }

  function _sortbyEnemy($a, $b) 
  {
    if($a["enemy"]==$b["enemy"]) { return 0; } 
    elseif($a["enemy"]<$b["enemy"]) { return 1; }
    else { return -1; }
  }  
}

?>