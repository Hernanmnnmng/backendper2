-- Stored Procedure: Update a leverancier
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS UpdateLeverancier(
    IN p_id INT,
    IN p_naam VARCHAR(255),
    IN p_contact_persoon VARCHAR(255),
    IN p_leverancier_nummer VARCHAR(50),
    IN p_mobiel VARCHAR(20),
    IN p_opmerking VARCHAR(255),
    IN p_is_actief BOOLEAN,
    OUT p_result_message VARCHAR(255),
    OUT p_success BOOLEAN
)
BEGIN
    DECLARE v_exists INT;
    DECLARE v_current_nummer VARCHAR(50);
    
    -- Check if leverancier exists
    SELECT COUNT(*) INTO v_exists
    FROM leveranciers
    WHERE id = p_id;
    
    IF v_exists = 0 THEN
        SET p_success = FALSE;
        SET p_result_message = 'Leverancier niet gevonden';
    ELSE
        -- Get current leverancier number
        SELECT LeverancierNummer INTO v_current_nummer
        FROM leveranciers
        WHERE id = p_id;
        
        -- Check if new number conflicts with another leverancier
        IF p_leverancier_nummer != v_current_nummer THEN
            SELECT COUNT(*) INTO v_exists
            FROM leveranciers
            WHERE LeverancierNummer = p_leverancier_nummer;
            
            IF v_exists > 0 THEN
                SET p_success = FALSE;
                SET p_result_message = 'Leveranciernummer bestaat al';
            ELSE
                -- Update leverancier
                UPDATE leveranciers
                SET naam = p_naam,
                    ContactPersoon = p_contact_persoon,
                    LeverancierNummer = p_leverancier_nummer,
                    Mobiel = p_mobiel,
                    Opmerking = p_opmerking,
                    IsActief = p_is_actief,
                    DatumGewijzigd = NOW(6)
                WHERE id = p_id;
                
                SET p_success = TRUE;
                SET p_result_message = 'Leverancier succesvol bijgewerkt';
            END IF;
        ELSE
            -- Update leverancier (number unchanged)
            UPDATE leveranciers
            SET naam = p_naam,
                ContactPersoon = p_contact_persoon,
                Mobiel = p_mobiel,
                Opmerking = p_opmerking,
                IsActief = p_is_actief,
                DatumGewijzigd = NOW(6)
            WHERE id = p_id;
            
            SET p_success = TRUE;
            SET p_result_message = 'Leverancier succesvol bijgewerkt';
        END IF;
    END IF;
END //

DELIMITER ;

