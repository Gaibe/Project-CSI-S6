<?php


final class Adresse {

    protected $id_adresse;

    protected $rue;

    protected $ville;

    protected $code_postal;



    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public static function findById($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM adresse WHERE id_adresse = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return Hydrator::hydrate($result, new Adresse());
    }

    public static function findByClientId($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM adresse INNER JOIN client_has_adresse 
            ON adresse_id_adresse = id_adresse
            WHERE client_id_client = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return Hydrator::hydrate($result, new Adresse());
    }

    public static function findByMagasinId($id) {
        $connection = base::getConnection();
        $stmt = $connection->prepare("SELECT * FROM adresse INNER JOIN magasin_has_adresse 
            ON adresse_id_adresse = id_adresse
            WHERE magasin_id_magasin = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return Hydrator::hydrate($result, new Adresse());
    }


    public function insert() {
        $connection = base::getConnection();
        $stmt = $connection->prepare("INSERT INTO adresse (rue, ville, code_postal) 
            VALUES (:rue, :ville, :code_postal)");
        $stmt->bindParam(':rue', $this->rue);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':code_postal', $this->code_postal);
        $stmt->execute();
    }
    
}