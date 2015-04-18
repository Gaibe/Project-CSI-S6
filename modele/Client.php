<?php

require_once("Adresse.php");

final class Client {

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

    protected $adresse;


    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }
    
    public static function findAll() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM client ORDER BY nom");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();

        return Hydrator::hydrate($result, new Client());
    }
    
    public static function findById($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM client WHERE id_client = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $client = Hydrator::hydrate($result, new Client());
        $client->adresse = Adresse::findByClientId($id);
        return $client;
    }

    public static function findByPseudo($pseudo) {
        $connection = base::getConnection();
        $pseudo = strtolower($pseudo);
        $stmt = $connection->prepare("SELECT * FROM client WHERE pseudo = :pseudo");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return Hydrator::hydrate($result, new Client());
    }

    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO client (nom, prenom, email, pseudo, mot_passe, role) 
            VALUES (:nom, :prenom, :email, :pseudo, :mot_passe, :role)");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':pseudo', $this->pseudo);
        $stmt->bindParam(':mot_passe', $this->mot_passe);
        $stmt->bindParam(':role', $this->role);
        $stmt->execute();

        $this->id_client = $connection->lastInsertId();

        $this->insertAdresse();
    }

    public function insertAdresse() {
        $connection = base::getConnection();
        if ($this->adresse !== -1) {
            $adresse = new Adresse();
            $adresse->__set('rue', $this->adresse->__get('rue'));
            $adresse->__set('ville', $this->adresse->__get('ville'));
            $adresse->__set('code_postal', $this->adresse->__get('code_postal'));
            $adresse->insert();

            $id_adresse = $connection->lastInsertId();

            $stmt2 = $connection->prepare("INSERT INTO client_has_adresse (client_id_client, adresse_id_adresse) 
                VALUES (:id_client,:id_adresse)");
            $stmt2->bindParam(':id_adresse', $id_adresse);
            $stmt2->bindParam(':id_client', $this->id_client);
            $stmt2->execute();

        }
    }

    public function update() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("UPDATE client 
            SET nom = :nom, prenom = :prenom, email = :email, pseudo = :pseudo  
            WHERE id_client = :id_client");
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':pseudo', $this->pseudo);
        $stmt->bindParam(':id_client', $this->id_client);
        $stmt->execute();

        if (Adresse::findByClientId($this->id_client) === -1) {
            $this->insertAdresse();
        }
        else {
            if ($this->adresse !== -1) {
                $this->adresse->update();
            }
        }
    }

}