<?php

/*
 *  gsQuery - Querys game servers
 *  Copyright (c) 2002-2004 Jeremias Reith <jr@gsquery.org>
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

/**
 * @brief Querys a halflife server
 * @author Jeremias Reith (jr@gsquery.org)
 * @version $Rev: 195 $
 *
 * Code is very ugly at the moment.
 * Does anyone have the protocol specs?<br>
 *
 * This class works with Halflife only.
 */
class hlife extends gsQuery
{
  var $playerFormat = '/sscore/x2/ftime';

  function rcon_query_server($command, $rcon_pwd)
  {
    $get_challenge="\xFF\xFF\xFF\xFFchallenge rcon\n";
    if(!($challenge_rcon=$this->_sendCommand($this->address,$this->queryport,$get_challenge))) {
      $this->debug['Command send ' . $command]='No challenge rcon received';
      return FALSE;
    }
    if (!ereg("challenge rcon ([0-9]+)", $challenge_rcon)) {
      $this->debug['Command send ' . $command]='No valid challenge rcon received';
      return FALSE;
    }
    $challenge_rcon=substr($challenge_rcon, 19,10);
    $command="\xFF\xFF\xFF\xFFrcon \"".$challenge_rcon."\" ".$rcon_pwd.' '.$command."\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      $this->debug['Command send ' . $command]='No reply received';
      return FALSE;
    } else {
      return substr($result, 5);
    }
  }
 
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
      
      $this->_processPlayers($result, $this->playerFormat, 8);
        
      $this->playerkeys['name']=TRUE;
      $this->playerkeys['score']=TRUE;
      $this->playerkeys['time']=TRUE;

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

  function getDebugDumps($html=FALSE, $dumper=NULL) {
    require_once(GSQUERY_DIR . 'requires/HexDumper.class.php');    

    if(!isset($dumper)) {
      $dumper = new HexDumper();
      $dumper->setDelimiter(0x00);
      $dumper->setEndOfHeader(0x04);
    }

    return parent::getDebugDumps($html, $dumper);
  }


  function _processPlayers($data, $format, $formatLength) 
  {
    $len = strlen($data);

    $posNextPlayer=$len;

    for($i=6;$i<$len;$i=$endPlayerName+$formatLength+1) { 
      // finding end of player name
      $endPlayerName = strpos($data, "\x00", ++$i);
      if($endPlayerName == FALSE) { return FALSE; } // abort on bogus data
      // unpacking player's score and time
      $curPlayer = unpack('@'.($endPlayerName+1).$format, $data);
      // format time
      if(array_key_exists('time', $curPlayer)) {
	$curPlayer['time'] = adodb_date('H:i:s', mktime(0, 0, $curPlayer['time']));
      }
      // extract player name
      $curPlayer['name'] = substr($data, $i, $endPlayerName-$i);
      // add player to the list of players
      $this->players[] = $curPlayer; 
    }
  }

 
}

?>
