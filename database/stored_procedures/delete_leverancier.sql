-- Stored Procedure: Delete (deactivate) a leverancier
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS DeleteLeverancier(
    IN p_id INT,
    OUT p_result_message VARCHAR(255),
    OUT p_success BOOLEAN
)
BEGIN
    DECLARE v_exists INT;
    DECLARE v_has_products INT;
    
    -- Check if leverancier exists
    SELECT COUNT(*) INTO v_exists
    FROM leveranciers
    WHERE id = p_id;
    
    IF v_exists = 0 THEN
        SET p_success = FALSE;
        SET p_result_message = 'Leverancier niet gevonden';
    ELSE
        -- Check if leverancier has products
        SELECT COUNT(*) INTO v_has_products
        FROM product_per_leverancier
        WHERE LeverancierId = p_id;
        
        IF v_has_products > 0 THEN
            -- Soft delete: set IsActief to false
            UPDATE leveranciers
            SET IsActief = 0,
                DatumGewijzigd = NOW(6)
            WHERE id = p_id;
            
            SET p_success = TRUE;
            SET p_result_message = 'Leverancier gedeactiveerd (heeft nog producten)';
        ELSE
            -- Hard delete: remove completely
            DELETE FROM leveranciers
            WHERE id = p_id;
            
            SET p_success = TRUE;
            SET p_result_message = 'Leverancier succesvol verwijderd';
        END IF;
    END IF;
END //

DELIMITER ;

