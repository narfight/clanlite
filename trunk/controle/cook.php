<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if ($config['securitee'] != "ok" || empty($session_cl['user']))
{
	secu($_SERVER['PHP_SELF']);
}
else if ( ($config['securitee'] != "ok" || $user_pouvoir['particulier']  != 'admin') && (!empty($niveau_secu) && $user_pouvoir[$niveau_secu] != "oui"))
{
	secu($config['site_domain'].$_SERVER['PHP_SELF']);
}
?>