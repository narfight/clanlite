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
define("A2S_SERVERQUERY_GETCHALLENGE", "\xFF\xFF\xFF\xFF\x57");
define("A2S_INFO", "\xFF\xFF\xFF\xFF\x54\x53\x6F\x75\x72\x63\x65\x20\x45\x6E\x67\x69\x6E\x65\x20\x51\x75\x65\x72\x79\x00");
define("A2S_PLAYER", "\xFF\xFF\xFF\xFF\x55"); // + <4 byte challenge number>
define("A2S_RULES", "\xFF\xFF\xFF\xFF\x56"); // + <4 byte challenge number>

class newshlife extends gsQuery
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

    //from an array of bytes keep reading as string until 0x00 terminator
    function _get_string($data, $pos)
    {
        $string = "";
        while (!$data[$pos]==0)
        {
          $string = $string.chr($data[$pos]);
          $pos++;
        }
        return $string;
    }
    //from an array of bytes, take 4 bytes starting at $pos and convert to little endian long 
    function _get_long($data, $pos)
    {
        $long = $data[$pos];
        for ($i=1; $i<4; $i++)
        {
          $pos++;
          $long << 8;
          $long += $data[$pos];
        }
        return $long;
    }
    
    function query_server($getPlayers=TRUE,$getRules=TRUE)
  {     
    // flushing old data if necessary
    if($this->online) {
      $this->_init();
    }
    
    $command="\xFF\xFF\xFF\xFF\x54\x53\x6F\x75\x72\x63\x65\x20\x45\x6E\x67\x69\x6E\x65\x20\x51\x75\x65\x72\x79\x00";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      return FALSE;
    }
    
    
      //unlike the other protocols implemented in this class the return value here
      //is a defined structure.  Because php can't handle structures unpack the string
      //into an array and step through the elements reading a bytes as required

      //Unpack used as follows...
      // I = 4 byte long
      // c = 1 byte
      // Format is always a long of -1 [header] followed by a byte [indicator] as validated
      // From that point on array elements are 1 based numeric values

      $data = unpack("Iheader/cindicator/c*", $result);

      if (!$data['header']==-1)
      {
        $this->debug[$command]="Not a hl server, expected 0xFF 0xFF 0xFF 0xFF in first 4 bytes";
        return FALSE;
      }

      if (!chr($data['indicator'])=="\x6D")
      {
        $this->debug[$command]="Not a hl server, expected 0x6D in byte 5";
        return FALSE;
      }

      $pos=1;

      $gameip = $this->_get_string($data, $pos);
      $pos += strlen($gameip) + 1;

      $hostname = $this->_get_string($data, $pos);
      $pos += strlen($hostname) + 1;

      $map = $this->_get_string($data, $pos);
      $pos += strlen($map) + 1;

      $gametype = $this->_get_string($data, $pos);
      $pos += strlen($gametype) + 1;

      $gamedesc = $this->_get_string($data, $pos);
      $pos += strlen($gamedesc) + 1;

      $numplayers = $data[$pos];
      $pos++;

      $maxplayers = $data[$pos];
      $pos++;

      $version = $data[$pos];
      $pos++;

      $dedicated = $data[$pos];
      $pos++;

      $os = $data[$pos];
      $pos++;

      $password = $data[$pos];
      $pos++;

      $ismod = $data[$pos];
      $pos++;

      //if this is a mod, get mod specific information
      if ($ismod==1)
      {

        $modurlinfo = $this->_get_string($data, $pos);
        $pos += strlen($modurlinfo) + 1;

        $modurldownload = $this->_get_string($data, $pos);
        $pos += strlen($modurldownload) + 1;

        $unused = $this->_get_string($data, $pos);
        $pos += strlen($unused) + 1;

        $modversion = $this->_get_long($data, $pos);
        $pos+=4;

        $modsize = $this->_get_long($data, $pos);
        $pos+=4;

        $serverside = $data[$pos];
        $pos++;

        $customclientdll = $data[$pos];
        $pos++;

      }

      $secure = $data[$pos];
      $pos++;

      $numbots = $data[$pos];
      $pos++;

      $this->gamename = $gamedesc;
      $this->gametype = $gametype;
      $this->hostport = $this->queryport;
      $this->servertitle = $hostname;
      $this->mapname = $map;
      $this->numplayers = $numplayers;
      $this->numplayers;
      $this->maxplayers = $maxplayers;
      $this->gameversion = "";
      $this->maptitle = "";
      $this->password = $password;
    
      //Before you can query the players and rules you have to get a 4 byte challenge number
      $command=A2S_SERVERQUERY_GETCHALLENGE;
      if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
        return FALSE;
      }

      $data = unpack("Iheader/cindicator/c4", $result); //Long followed by bytes

      if (!$data['header']==-1)
      {
        $this->debug[$command]="Invlaid challenge no reponse, expected 0xFF 0xFF 0xFF 0xFF in first 4 bytes";
        return FALSE;
      }

      if (!$data['indicator']=="\x41")
      {
        $this->debug[$command]="Invlaid challenge no reponse, expected 0x41 in byte 5";
        return FALSE;
      }

      //build a string containing the number to be sent
      $challengeno = chr($data[1]).chr($data[2]).chr($data[3]).chr($data[4]);

      // get players
      if($this->numplayers && $getPlayers) {

        $command=A2S_PLAYER.$challengeno;
        if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
          return FALSE;
        }

        $data = unpack("Iheader/cindicator/cnumplayers/c*", $result);

        if (!$data['header']==-1)
        {
          $this->debug[$command]="Invlaid player reponse, expected 0xFF 0xFF 0xFF 0xFF in first 4 bytes";
          return FALSE;
        }

        if (!$data['indicator']=="\x44")
        {
          $this->debug[$command]="Invlaid player reponse, expected 0x44 in byte 5";
          return FALSE;
        }

        $numplayers = $data[numplayers];

        $pos = 1;
        for ($i=0; $i<$numplayers; $i++)
        {

          $index = $data[$pos];
          $pos++;

          $players[$index]["name"] = $this->_get_string($data, $pos);
          $pos += strlen($players[$index]["name"]) + 1;


          $players[$index]["score"] = $this->_get_long($data, $pos);
          $pos += 4;

          //Todo: Get time connected from next 4 bytes as double
          $pos += 4;

        }

        $this->playerkeys["name"]=TRUE;
        $this->playerkeys["score"]=TRUE;
        $this->players=$players;

      }

      //get the server rules
      $command=A2S_RULES.$challengeno;
      if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
        return FALSE;
      }

      //This seems to start with a long of -2 then 4 more bytes (don't know what they are), then a byte of 2.
      //The same 9 bytes are repated at offset 1400, so remove them both
      //I assume this is some kind of packet check, if anyone can explain to me, please do - BH
      $offset = 0;
      $newresult = "";
      while ($offset < strlen($result))
      {
        $newresult = $newresult.substr($result, $offset + 9, 1391);
        $offset+=1400;
      }
      $result = $newresult;

      //unpack string now that it is formatted as expected
      // s = 2 byte integer
      $data = unpack("Iheader/cindicator/snumrules/c*", $result);

      if (!$data[header]==-1)
      {
        $this->debug[$command]="Invlaid rules reponse, expected 0xFF 0xFF 0xFF 0xFF in first 4 bytes";
        return FALSE;
      }

      if (!$data[indicator]=="\x45")
      {
        $this->debug[$command]="Invlaid rules reponse, expected 0x45 in byte 5";
        return FALSE;
      }

      $numrules = $data[numrules];

      $pos = 1;
      for ($i=1; $i<$numrules; $i++)
      {

        $rulename = $this->_get_string($data, $pos);
        $pos += strlen($rulename) + 1;

        $rulevalue = $this->_get_string($data, $pos);
        $pos += strlen($rulevalue) + 1;

        $this->rules[$rulename] = $rulevalue;

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
