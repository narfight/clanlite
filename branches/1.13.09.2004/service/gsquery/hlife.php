<?php

/*
 *  gsQuery - Querys game servers
 *  Copyright (c) 2002-2004 Jeremias Reith <jr@terragate.net>
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

require_once GSQUERY_DIR . 'quake.php';

/**
 * @brief Querys a halflife server
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: hlife.php,v 1.18 2004/08/12 19:14:47 jr Exp $
 *
 * Code is very ugly at the moment.
 * Does anyone have the protocol specs?<br>
 *
 * This class works with Halflife only.
 */
class hlife extends quake
{
  function getGameJoinerURI()
  {
    return 'gamejoin://hlife@'. $this->address .':'. $this->hostport .'/'. $this->gametype;
  }

  function query_server($getPlayers=TRUE,$getRules=TRUE)
  {     
    // flushing old data if necessary
    if($this->online) {
      $this->_init();
    }
    
    $command="\xFF\xFF\xFF\xFFinfostring\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      return FALSE;
    }
    
    
    $exploded_data = explode("\\", $result);
    for($i=1;$i<count($exploded_data);$i++) {
      switch($exploded_data[$i++]) {
      case 'address':
	if ($exploded_data[$i] == 'loopback') {
	  $this->hostport = $this->queryport;
	} else {
	  list($ip, $this->hostport) = explode(':', $exploded_data[$i]);
	}
	break;
      case 'hostname':
	$this->servertitle = $exploded_data[$i];
	break;
      case 'map':
	$this->mapname = $exploded_data[$i];
	break;
      case 'players':
	$this->numplayers = $exploded_data[$i];
	break;
      case 'max':
	$this->maxplayers = $exploded_data[$i];
	break;
      case 'protocol':
	$this->gameversion = ($exploded_data[$i] == 47)? '1.6' : '1.5';
	break;
      case 'gamedir':
	$this->gamename = 'hlife_' . $exploded_data[$i];
	$this->gametype = $exploded_data[$i];
	break;
      }
    }
    
    // get players
    if($this->numplayers && $getPlayers) {
      $command="\xFF\xFF\xFF\xFFplayers\n";
      if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
	return FALSE;
      }
      
      // Process Player Data
      $j=7;  //pointer into player data string.  We start at 7 (past header bytes)
      $listedplayers=ord($result{5}); // Number of players actually being listed
      for($i=0;$i<$listedplayers;$i++) {       
	while($result[$j]!=chr(0)) $players[$i]['name'].=$result[$j++];
	$j++;
	$t= ord($result{$j}) | (ord($result{$j+1})<<8) | (ord($result{$j+2})<<16) | (ord($result{$j+3})<<24);
	$players[$i]['score']=$t;
	if($players[$i]['score']>128) {
	  $players[$i]['score']-=256;
	}
	
	$j+=4;
	$t= unpack('ftime', substr($result, $j, 4));
	$t= mktime(0, 0, $t['time']);
	$players[$i]['time'] = date('H:i:s', $t);
	$j+=5;  
      }
      
      $this->playerkeys['name']=TRUE;
      $this->playerkeys['score']=TRUE;
      $this->playerkeys['time']=TRUE;
      $this->players=$players;
    }
    $this->gametype = ($this->gametype == 'cstrike') ? $this->gametype.' '.$this->gameversion : $this->gametype;
    
    // get rules
    $command="\xFF\xFF\xFF\xFFrules\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      return FALSE;
    }
    
    // rules can be in multiple packets, we have to sort it out
    // First packet has a 16 byte header, subsequent packet has an 8 byte header.
    $str="/\xFE\xFF\xFF\xFF/";// packet signature (both first and second start with this)
    
    $block=preg_split($str,$result,-1,PREG_SPLIT_NO_EMPTY);
    
    $str="/\xFF\xFF\xFF\xFF/"; // first packet signature (only first packet matches this)
    
    if(!empty($block[0]) && !empty($block[1])) {
      if(preg_match($str, $block[0])) {
	$result = substr($block[0], 12, strlen($block[0])).substr($block[1], 5, strlen($block[1]));      
      } elseif(preg_match($str, $block[1])) {
	$result = substr($block[1], 12, strlen($block[1])).substr($block[0], 5, strlen($block[1])).substr($block[0], 5, strlen($block[0]));
      }
    } elseif (!empty($block[0])) {
      $result = substr($block[0], 5, strlen($block[0]));
    }


    $exploded_data = explode("\x00", $result);
    $this->password = -1;

    for($i=0;$i<count($exploded_data);$i++) {
      switch($exploded_data[$i++]) {
      case 'sv_password':
	$this->password=$exploded_data[$i];
	break;
      case 'amx_nextmap':
	$this->nextmap=$exploded_data[$i];
	break;
      case 'cm_nextmap':
	$this->nextmap=$exploded_data[$i];
	break;
      default:
	if(isset($exploded_data[$i-1]) && isset($exploded_data[$i])) {
	  $this->rules[$exploded_data[$i-1]]=$exploded_data[$i];
	}
      }
    }
    $this->online = TRUE;
    return TRUE;
  }
 
}

?>
