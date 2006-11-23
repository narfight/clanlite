<?php
/****************************************************************************
 *	Fichier		: mysqli.php												*
 *	Copyright	: (C) 2004 ClanLite											*
 *	Email		: support@clanlite.org										*
 *																			*
 *   This program is free software; you can redistribute it and/or modify	*
 *   it under the terms of the GNU General Public License as published by	*
 *   the Free Software Foundation; either version 2 of the License, or		*
 *   (at your option) any later version.									*
 ***************************************************************************/
class mysql
{
	//Déclaration des variables de classe
	var $nb_req = 0;	//nombre de requette
	var $error;		//erreur possible a une requette
	var $time = 0;	//nombre de µs total prit pour les requettes SQL
	function mysql_connection($mysqlhost, $login, $password, $base)
	{
		$tmp = getmicrotime();
		$this->id_link = @mysqli_connect($mysqlhost, $login, $password);
		if(!$this->id_link)
		{
			$this->error = 'Connexion impossible sur <strong>le serveur '.$mysqlhost.'</strong><br />Vérifiez les paramètres de connection<br />L\'erreur est : '.mysqli_connect_error();
			return false;
			exit;
		}
		if(!@mysqli_select_db($this->id_link, $base))
		{
			$this->error = 'Connexion impossible sur <strong>la base de données '.$base.'</strong><br />Vérifiez les paramètres de connection.<br /> L\'erreur est : '.mysqli_error($this->id_link);
			return false;
			exit;
		}
		$this->time = getmicrotime()-$tmp;
		return true;		
	}
	
	function mysql_deconnection($close_link='')
	{
		$tmp = getmicrotime();
		if ($close_link === '')
		{
			$close_link = $this->id_link;
		}
		$data = mysqli_close($close_link);
		$this->time = getmicrotime()-$tmp;
		return $data;
	}

	function debug()
	{
		foreach($this->log_debug as $requette_num => $nfo_requette)
		{// fait la des requettes
			echo $requette_num.'<hr />';
			echo 'Pour :'.$nfo_requette['group'].'<br />Temps :'.$nfo_requette['temps'].'<br />requette :'.$nfo_requette['requette'].'<br />pour :'.$nfo_requette['pour'].'<br />Erreur :'.$nfo_requette['erreur'];
		}
	}
	//renvoie le nombre de lignes affecter par la derniére requette
	function requete_nb_row()
	{
		$tmp = getmicrotime();
		$data = mysqli_affected_rows();
		$this->time = getmicrotime()-$tmp;
		return $data;
	}
	//Renvoie le nombre de champs
	function requete_nb_cols($for)
	{
		$tmp = getmicrotime();
		$data = mysqli_num_fields($for);
		$this->time = getmicrotime()-$tmp;
		return $data;
	}
	//Envois la requette au serveur Mysql	
	function requete_sql($sql, $group='indeterminé', $info='indeterminé')
	{
		$tmp = getmicrotime();
		$this->sql = $sql;
		$this->query = mysqli_query($this->id_link, $this->sql);
		$this->error = mysqli_error($this->id_link);
		$this->nb_req++;
		$this->log_debug[$this->nb_req] = array(
			'requette' => $sql,
			'pour' => $info,
			'group' => $group,
			'erreur' =>$this->error
		);
		$this->time = getmicrotime()-$tmp;
		$this->log_debug[$this->nb_req]['temps'] = getmicrotime()-$tmp;
		return $this->query;
	}
	function s_array($query)
	{
		$tmp = getmicrotime();
		$data = (empty($query))? false : mysqli_fetch_array($query);
		$this->time = getmicrotime()-$tmp;
		return $data;
	}
	function nbr($query)
	{
		$tmp = getmicrotime();
		$data = (empty($query))? false : mysqli_num_rows($query);
		$this->time = getmicrotime()-$tmp;
		return $data;
	}
}
?>