<?php

/*
 *  gsQuery - Querys various game servers
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

require_once GSQUERY_DIR . 'gsQuery.php';

/**
 * @brief Abstract class that implements quake related stuff
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: quake.php,v 1.2 2004/08/12 19:14:47 jr Exp $
 *
 * Implements everything that all quake protocols have in common
 */
class quake extends gsQuery
{

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
      $this->debug['Command send ' . $command]='No challenge rcon received';
      return FALSE;
    }
    if (!ereg("challenge rcon ([0-9]+)", $challenge_rcon)) {
      $this->debug['Command send ' . $command]='No valid challenge rcon received';
      return FALSE;
    }
    $challenge_rcon=substr($challenge_rcon, 19,10);
    $command="\xFF\xFF\xFF\xFFrcon \"".$challenge_rcon."\" ".$rcon_psw.' '.$command."\n";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
      $this->debug['Command send ' . $command]='No reply received';
      return FALSE;
    } else {
      return substr($result, 5);
    }
  }
 
}
?>
