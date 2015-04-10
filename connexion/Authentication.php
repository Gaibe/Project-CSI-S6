<?php
require_once '../modele/Client.php';
require_once 'AuthException.php';


class Authentication {
    
    
    //fonction permettant d'authentifier un utilisateur
    public static function Authenticate ( $pseudo, $password ) {
        // charger utilisateur $client
        $client = Client::findByPseudo($pseudo);
        // vérifier $client->hash == hash($password)
        if($client->__get('mot_passe') == sha1($password)){
            // charger profil ($client->id)
            Authentication::loadProfile($client->__get('userid'));
        }
        else{
            throw new AuthException();
        }
    }
    
    //fonction permettant de charger un profil
    private static function loadProfile( $client_id ) {
        // charger l'utilisateur et ses droits
        $client = Client::findById($client_id);
        // détruire la variable de session
        session_destroy();
        // créer variable de session = profil chargé
        session_start();
        $_SESSION['membre'] = $client_id;
        $_SESSION['login'] = $client->__get('login');
        if ($client->__get('role') === 'admin') {
            $_SESSION['admin'] = true;
        }
    }
}
