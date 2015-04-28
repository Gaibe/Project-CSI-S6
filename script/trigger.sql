delimiter //

CREATE TRIGGER panier_has_produit_delete_t
AFTER DELETE ON panier_has_produit
FOR EACH ROW
BEGIN
    IF (SELECT COUNT(*)
        FROM panier_has_produit
        WHERE panier_id_panier = OLD.panier_id_panier) = 0 
    THEN

        UPDATE panier SET prix_total = 0.00, quantite_totale = 0
        WHERE id_panier = OLD.panier_id_panier;
    END IF;
END//



delimiter ;