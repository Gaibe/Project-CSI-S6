 <?php

class base{


	private static $connection;

	private static $host = "localhost";
	private static $user = "projet_csi";
	private static $pass = "csi";
	private static $base = "projet_csi";

	/* Permet d'obtenir une connection à la base 
	 * (Les paramètres de connections sont stockés dans le fichier paramco.php) 
	 * Il faut créer une connection PDO distante
	 */
	public static function getConnection(){
		if (isset(self::$connection)) {
			return self::$connection;
		}else{
			self::$connection = self::connect();
			return self::$connection;
		}		
	}


	public static function connect(){
		//global $host, $user, $pass, $base;
		try{
			$dns = "mysql:host=" . self::$host . ";dbname=" . self::$base . ";";
			$connection = new PDO($dns, self::$user, self::$pass,	
					array(PDO::ERRMODE_EXCEPTION=>true, PDO::ATTR_PERSISTENT=>true));
			$connection->exec("SET CHARACTER SET utf8");
			echo "CONNECTION ETABLIE";
			return($connection);
		}catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
		
	}
}
?>