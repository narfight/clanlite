<?php

/*
 *  gsQuery - Querys various game servers
 *  Copyright (c) 2004 Narfight (Jean-Pierre Sneyers) <narfight@lna.be>
 *  Copyright (c) 2004 Jeremias Reith <jr@terragate.net>
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

include_once("q3a.php");


/**
 * @brief Uses the Quake 3 protcol to communicate with the server
 * @author Narfight (Jean-Pierre Sneyers) <narfight@lna.be>
 * @version $Id: sof2.php,v 1.2 2004/05/17 05:49:14 jr Exp $
 *
 * This class is capable of translating color tags from SOF2.
 */
class sof2 extends q3a
{


  /**
   * @brief htmlizes the given raw string
   *
   * @param var a raw string from the gameserver that might contain special chars
   * @return a html version of the given string
   */
  function htmlize($var) 
  {
    $var = htmlspecialchars($var);

    while(ereg("\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])", $var)) {
      if (ereg("\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])(.*)\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])", $var)) {
	$var = preg_replace("#\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])(.*)\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])#Usi", "<span class=\"gsquery-$1\">$2</span>^$3", $var);
      } else {
	$var = preg_replace("#\^([0-9a-zA-Z]|-|=|[|]|;|'|\|/|,|.|\?|-|_])(.*)$#Usi", "<span class=\"gsquery-$1\">$2</span>", $var);
      }
    }
    // replace illegal css
    $var = str_replace("gsquery-&", "gsquery-et", $var);
    $var = str_replace("gsquery-'", "gsquery-apos", $var);
    $var = str_replace("gsquery-)", "gsquery-par", $var);
    $var = str_replace("gsquery-=", "gsquery-egal", $var);
    $var = str_replace("gsquery-?", "gsquery-ques", $var);
    $var = str_replace("gsquery-.", "gsquery-point", $var);
    
    return $var;    
  }
}
?>
