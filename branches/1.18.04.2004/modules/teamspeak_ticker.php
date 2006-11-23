<?php
// -------------------------------------------------------------
// LICENCE : GPL vs2.0 [ voir /docs/COPYING ]
// -------------------------------------------------------------
if (defined('CL_AUTH'))
{
	if( !empty($get_nfo_module) )
	{
		$filename = basename(__FILE__);
		$nom = "Ticker Teamspeak";
		return;
	}
	if( !empty($module_installtion) || !empty($module_deinstaller) )
	{
		return;
	}
	if (defined('CL_AUTH'))
	{
		$tpl_filename = $template->make_filename('modules/teamspeak_ticker.tpl');
		
		$tpl = fread(fopen($tpl_filename, 'r'), filesize($tpl_filename));
		
		// replace \ with \\ and then ' with \'.
		$tpl = str_replace('\\', '\\\\', $tpl);
		$tpl = str_replace('\'', '\\\'', $tpl);
		
		// strip newlines.
		$tpl  = str_replace("\n", '', $tpl);
		
		// vérifie si le site du constructeur est en ligne
		$nfo_module = explode("|!|", $modules['config']);
		$reponce = @fopen($nfo_module[0], "r");
		if ($reponce)
		{ 
			fclose($reponce);
			$reponce = file ($nfo_module[0]);
		}	
		$tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" . '$block[\'\\1\'] = \'\\2\';', $tpl);
		eval($tpl);
			
		if (!empty($reponce[0]) && $reponce[0] == "on\n")
		{// le ticker répond que tout va bien on peux afficher
			$ts_boucle = "";
			$color = "";
			foreach($reponce as $key=>$val)
			{ 
				$traiter = explode("/*-/", $val);
				$color = ($color == "table-cellule")? "table-cellule-2" : "table-cellule";
				if (!empty($traiter[1]) && !empty($traiter[3]) && !empty($traiter[5]))
				{
					$ts_boucle_beta = str_replace('{IP}', $traiter[1], $block['ts_ticker_boucle']);
					$ts_boucle_beta = str_replace('{PORT}', $traiter[3], $ts_boucle_beta);
					$ts_boucle_beta = str_replace('{URL_WEBPOST}', $nfo_module[1], $ts_boucle_beta);
					$ts_boucle_beta = str_replace('{CONNECTER}', $traiter[10], $ts_boucle_beta);
					$ts_boucle_beta = str_replace('{COLOR}', $color, $ts_boucle_beta);
					$ts_boucle_beta = str_replace('{ID}', $traiter[7], $ts_boucle_beta);
					$ts_boucle .= str_replace('{NAME}', $traiter[5], $ts_boucle_beta);
				}
			}
			$block['ts_ticker_corps'] = str_replace('{LISTE}', $ts_boucle, $block['ts_ticker_corps']);
			
			$template->assign_block_vars("modules_".$modules['place'], array( 
				'TITRE' =>  $modules['nom'],
				'IN' => $block['ts_ticker_corps']
			));
		}
		else
		{
			$template->assign_block_vars("modules_".$modules['place'], array( 
				'TITRE' =>  $modules['nom'],
				'IN' => $langue['offline_module_ticker_ts']
			));
		}
	}
	return;
}
if( !empty($HTTP_GET_VARS['config_modul_admin']) || !empty($HTTP_POST_VARS['Submit_module']) )
{
	$root_path = './../';
	$action_membre= 'where_module_ticker_ts';
	$niveau_secu = 16;
	include($root_path."conf/template.php");
	include($root_path."conf/conf-php.php");
	include($root_path."controle/cook.php");
	$id_module = (!empty($HTTP_POST_VARS['id_module']))? $HTTP_POST_VARS['id_module'] : $HTTP_GET_VARS['id_module'];
	if ( !empty($HTTP_POST_VARS['Submit_module']) )
	{
		$sql = "UPDATE ".$config['prefix']."modules SET config='".$HTTP_POST_VARS['url']."|!|".$HTTP_POST_VARS['url_webpost']."' WHERE id ='".$id_module."'";
		if (! ($rsql->requete_sql($sql)) )
		{
			sql_error($sql, $rsql->error, __LINE__, __FILE__);
		}
		redirec_text($root_path."administration/modules.php" ,$langue['redirection_module_ticker_ts_edit'] ,"admin");
	}
	include($root_path."conf/frame_admin.php");
	$template = new Template($root_path."templates/".$config['skin']);
	$template->set_filenames( array('body' => 'modules/teamspeak_ticker.tpl'));
	$sql = "SELECT config FROM ".$config['prefix']."modules WHERE id ='".$id_module."'";
	if (! ($get = $rsql->requete_sql($sql)) )
	{
		sql_error($sql, $rsql->error, __LINE__, __FILE__);
	}
	$recherche = $rsql->s_array($get);
	$nfo_module = explode("|!|", $recherche['config']);
	$template->assign_block_vars('ts_ticker_config',array(
		'TITRE' => $langue['titre_module_ticker_ts'],
		'WEBPOST' => $langue['webpost_module_ticker_ts'],
		'TICKER_NSD' => $langue['ticker_nsd_module_ticker_ts'],
		'EDITER' => $langue['editer'],
		'ID'=> $id_module,
		'URL'=> ( !empty($nfo_module[0]) )? $nfo_module[0] : "",
		'URL_WEBPOST'=> ( !empty($nfo_module[1]) )? $nfo_module[1] : "",
	));
	$template->pparse('body');
	include($root_path."conf/frame_admin.php");
	return;
}
?>