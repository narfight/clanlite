<?php
/****************************************************************************
 *	Fichier		: 															*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
if ($config['securitee'] !== 'ok' || empty($session_cl['user']))
{
	secu($_SERVER['REQUEST_URI']);
}
else if ( ($config['securitee'] !== 'ok' || $session_cl['pouvoir_particulier']  != 'admin') && (!empty($niveau_secu) && $user_pouvoir[$niveau_secu] != 'oui'))
{
	secu($config['site_domain'].$_SERVER['REQUEST_URI']);
}
?>