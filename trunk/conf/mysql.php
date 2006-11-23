<?
class mysql
{
	//Déclaration des variables de classe
	var $nb_req = 0; //nombre de requette
	var $error; //erreur possible a une requette

	function mysql_connection($mysqlhost, $login, $password, $base)
	{
		if(!@mysql_connect($mysqlhost, $login, $password))
		{
			return "Connexion impossible sur le serveur <b>".$mysqlhost."</b><br />Vérifiez les paramètres de connection";
			exit;
		}
		if(!@mysql_select_db($base))
		{
			return "Connexion impossible sur la base de données <b>".$base."</b><br />Vérifiez les paramètres de connection";
			exit;
		}
	return true;		
	}
	
	function debug()
	{
		foreach($this->log_debug as $requette_num => $nfo_requette)
		{// fait la des requettes
			echo "<hr />".$requette_num."<hr />";
			echo "Pour :".$nfo_requette['group']."<br />requette :".$nfo_requette['requette']."<br />pour :".$nfo_requette['pour']."<br />Erreur :".$nfo_requette['erreur'];
		}
	}
	//renvoie le nombre de lignes affecter par la derniére requette
	function requete_nb_row()
	{
		return mysql_affected_rows();
	}
	//Renvoie le nombre de champs
	function requete_nb_cols($for)
	{
		return mysql_num_fields($for);
	}
	//Envois la requette au serveur Mysql	
	function requete_sql($sql, $group='indeterminé', $info='indeterminé')
	{
		$this->sql = $sql;
		$this->query = mysql_query($this->sql);
		$this->error = mysql_error();
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
		return (! $query )? '' : mysql_fetch_array($query);
	}
	function nbr($query)
	{
		return (! $query )? '' : mysql_num_rows($query);
	}
}
?>