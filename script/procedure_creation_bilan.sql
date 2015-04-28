DELIMITER |

CREATE PROCEDURE generer_bilan(IN v_type VARCHAR(15))
BEGIN

	DECLARE v_finished INTEGER DEFAULT 0;
	DECLARE v_idbilan INTEGER;
	DECLARE v_panier BIGINT(10);
	DECLARE v_prod BIGINT(5);
	DECLARE v_valide INTEGER;
	DECLARE v_QUANTITE INTEGER;
	DECLARE v_prix FLOAT;
	DECLARE v_nbVentes INTEGER;
	DECLARE v_montant FLOAT;
	DECLARE v_montanttotal FLOAT;
    
	DECLARE mycursor CURSOR FOR 
	SELECT panier_id_panier, produit_id_produit, est_valide, quantite, prix_produit, SUM(quantite) AS nbVentes, SUM(quantite * prix_produit) AS montant 
	FROM panier INNER JOIN panier_has_produit ON id_panier = panier_id_panier 
	WHERE est_valide = 1 
	GROUP BY produit_id_produit 
	ORDER BY produit_id_produit;
    
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET v_finished = 1;
	
	
	
	OPEN mycursor;
	
	INSERT INTO bilan (montant_total, type) VALUES (0.00, v_type);
    SET v_idbilan = (SELECT LAST_INSERT_ID()); 
    
    
	boucle: LOOP
	
	FETCH mycursor INTO v_panier, v_prod, v_valide, v_QUANTITE, v_prix, v_nbVentes, v_montant;
	
	IF v_finished = 1 THEN 
	LEAVE boucle;
	END IF;
	
	INSERT INTO bilan_has_produit (bilan_id_bilan, produit_id_produit, quantite, montant) VALUES (v_idbilan, v_prod, v_nbVentes, v_montant);
	
	END LOOP boucle;
	
	CLOSE mycursor;
	
	SET v_montanttotal = (SELECT SUM(montant) FROM bilan_has_produit WHERE bilan_id_bilan = v_idbilan);
	
	UPDATE bilan SET montant_total= v_montanttotal WHERE id_bilan = v_idbilan;
    
END|

DELIMITER ;