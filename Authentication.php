<?php
require_once 'modele/Utilisateur.php';
require_once 'AuthException.php';

class Authentication {
	
	//fonction permettant de créer un nouvel utilisateur
	public static function createUser ( $userName, $password ) {
		$crypte = sha1($password);
		// créer et sauvegarder l'utilisateur
		$u = new Utilisateur();
		$u->__set('login',$userName);
		$u->__set('password',$crypte);
		$u->insert();
	}
	
	//fonction permettant d'authentifier un utilisateur
	public static function Authenticate ( $username, $password ) {
		// charger utilisateur $user
		$u = Utilisateur::findByLogin($username);
		// vérifier $user->hash == hash($password)
		if($u->__get('password')==sha1($password)){
			// charger profil ($user->id)
			Authentication::loadProfile($u->__get('userid'));
		}
		else{
			throw new AuthException();
		}
	}
	
	//fonction permettant de charger un profil
	private static function loadProfile( $uid ) {
		// charger l'utilisateur et ses droits
		$u = Utilisateur::findById($uid);
		// détruire la variable de session
		session_destroy();
		// créer variable de session = profil chargé
		session_start();
		$_SESSION['userid'] = $uid;
		$_SESSION['login'] = $u->__get('login');
	}
}

?>