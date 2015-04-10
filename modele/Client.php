<?php
require_once "ModelExtends.php";

final class Client extends ModelExtends {

    // role
    const MEMBRE = 'membre';
    const ADMIN = 'admin';

    protected $id_client;

    protected $nom;

    protected $prenom;

    protected $email;

    protected $pseudo;

    protected $mot_passe;

    protected $date_creation;

    protected $role = self::MEMBRE;


    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public static function findById($id)
    {
        $result = parent::findByIdAbstract('client', $id);
        return parent::hydrate($result, new Client());
    }

    public static function findByPseudo($pseudo) 
    {
        $result = parent::findByPseudoAbstract('client', $pseudo);
        var_dump($result);
        exit;
        return parent::hydrate($result, new Client());
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO client (nom, prenom, email, pseudo, mot_passe, role) VALUES (:nom, :prenom, :email, :pseudo, :mot_passe, :role)");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':pseudo', $this->pseudo);
        $stmt->bindParam(':mot_passe', $this->mot_passe);
        $stmt->bindParam(':role', $this->role);
        $stmt->execute();
    }


    
}