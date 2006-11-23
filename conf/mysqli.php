<?php
class mysql
{
	//Déclaration des variables de classe
	var $nb_req = 0; //nombre de requette
	var $error; //erreur possible a une requette

	function mysql_connection($mysqlhost, $login, $password, $base)
	{
		if(!$this->links=@mysqli_connect($mysqlhost, $login, $password, $base))
		{
			return 'Connexion impossible sur <b>le serveur '.$mysqlhost.'</b><br />Vérifiez les paramètres de connection ('.mysqli_connect_error().')';
			exit;
		}
	return true;		
	}
	
	function debug()
	{
		foreach($this->log_debug as $requette_num => $nfo_requette)
		{// fait la liste des requettes
			echo "<hr />".$requette_num."<hr />";
			echo "Pour :".$nfo_requette['group']."<br />requette :".$nfo_requette['requette']."<br />pour :".$nfo_requette['pour']."<br />Erreur :".$nfo_requette['erreur'];
		}
	}
	//renvoie le nombre de lignes affecter par la derniére requette
	function requete_nb_row()
	{
		return mysqli_affected_rows();
	}
	//Renvoie le nombre de champs
	function requete_nb_cols($for)
	{
		return mysqli_num_fields($for);
	}
	//Envois la requette au serveur Mysql	
	function requete_sql($sql, $group='indeterminé', $info='indeterminé')
	{
		$this->sql = $sql;
		$this->query = mysqli_query($this->links, $this->sql);
		$this->error = mysqli_error($this->links);
		$this->nb_req++;
		$this->log_debug[$this->nb_req] = array(
			'requette' => $sql,
			'pour' => $info,
			'group' => $group,
			'erreur' =>$this->error
		);
		return $this->query;
	}
	function s_array($query)
	{
		return (! $query )? '' : mysqli_fetch_array($query, MYSQLI_ASSOC);
	}
	function nbr($query)
	{
		return (! $query )? '' : mysqli_num_rows($query);
	}
}
?>