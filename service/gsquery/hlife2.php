<?php

/*
* gsQuery - Querys game servers
* Copyright (c) 2002-2004 Jeremias Reith <jr@gsquery.org>
* http://www.gsquery.org
*
* This file is part of the gsQuery library.
*
* The gsQuery library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* The gsQuery library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with the gsQuery library; if not, write to the
* Free Software Foundation, Inc.,
* 59 Temple Place, Suite 330, Boston,
* MA 02111-1307 USA
*
*/

require_once GSQUERY_DIR . 'hlife.php';

/**
* @brief This class implements the protocol used by halflife 2
* @author Curtis Brown <webmaster@2dementia.com>
* @version $Rev: 192 $
* @todo preventing DoS with data containing no \x00's
* @todo clean up for basic info retrieval required
*/
class hlife2 extends hlife
{

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

$this->hostport = $this->queryport;

$i=4;// start after header
$this->rules['Type']=($result[$i++]=='I' ? 'Source' : 'HL1');
$this->rules['NetworkVersion']=ord(substr($result,$i++,1));
while ($result[$i]!=chr(0)) $this->servertitle.=$result[$i++];
$i++;
while ($result[$i]!=chr(0)) $this->mapname.=$result[$i++];
$i++;
while ($result[$i]!=chr(0)) $this->rules['gamedir'].=$result[$i++];
$i++;
while ($result[$i]!=chr(0)) $this->gamename.=$result[$i++];
$i++;
$this->rules['appid']=ord(substr($result,$i,2));$i=$i+2;
$this->numplayers=ord(substr($result,$i++,1));
$this->maxplayers=ord(substr($result,$i++,1));
$this->rules['botplayers']=ord(substr($result,$i++,1));
$this->rules['dedicated']=($result[$i++]=='d' ? 'Yes' : 'No');
$this->rules['server_os']=($result[$i++]=='l' ? 'Linux' : 'Windows');
$this->password=ord(substr($result,$i++,1));
$this->rules['secure']=($result[$i++]=='1' ? 'Yes' : 'No');
while ($result[$i]!="\x00") $this->gameversion.=$result[$i++];
$i++;

// do rules
//challange
$command="\xFF\xFF\xFF\xFF\x57";
if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
return FALSE;
}
$challenge=substr($result,-4);
//query
$command="\xFF\xFF\xFF\xFF\x56";
if(!($result=$this->_sendCommand($this->address,$this->queryport,$command.$challenge))) {
return FALSE;
}
$exploded_data = explode(chr(0), $result);

$z=count($exploded_data);
for($i=1;$i<$z;$i++) {
switch($exploded_data[$i++]) {
case 'sv_password':
$this->password=$exploded_data[$i];
break;
case 'deathmatch':
if ($exploded_data[$i]=='1') $this->gametype='Deathmatch';
break;
case 'coop':
if ($exploded_data[$i]=='1') $this->gametype='Cooperative';
break;
default:
if(isset($exploded_data[$i-1]) && isset($exploded_data[$i])) {
$this->rules[$exploded_data[$i-1]]=$exploded_data[$i];
}
}
}

if($getPlayers) {
//challange
$command="\xFF\xFF\xFF\xFF\x57";
if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) {
return FALSE;
}
$challenge=substr($result,-4);
//query
$command="\xFF\xFF\xFF\xFF\x55";
if(!($result=$this->_sendCommand($this->address,$this->queryport,$command.$challenge))) {
return FALSE;
}
$this->_processPlayers($result, $this->playerFormat, 8);

$this->playerkeys['name']=TRUE;
$this->playerkeys['score']=TRUE;
$this->playerkeys['time']=TRUE;
}

$this->online = TRUE;
return TRUE;
}
}

?>