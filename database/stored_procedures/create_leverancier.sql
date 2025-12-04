-- Stored Procedure: Create a new leverancier
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS CreateLeverancier(
    IN p_naam VARCHAR(255),
    IN p_contact_persoon VARCHAR(255),
    IN p_leverancier_nummer VARCHAR(50),
    IN p_mobiel VARCHAR(20),
    IN p_opmerking VARCHAR(255),
    OUT p_new_id INT,
    OUT p_result_message VARCHAR(255),
    OUT p_success BOOLEAN
)
BEGIN
    DECLARE v_exists INT;
    
    -- Check if leverancier number already exists
    SELECT COUNT(*) INTO v_exists
    FROM leveranciers
    WHERE LeverancierNummer = p_leverancier_nummer;
    
    IF v_exists > 0 THEN
        SET p_success = FALSE;
        SET p_result_message = 'Leveranciernummer bestaat al';
        SET p_new_id = NULL;
    ELSE
        -- Insert new leverancier
        INSERT INTO leveranciers (
            naam,
            ContactPersoon,
            LeverancierNummer,
            Mobiel,
            Opmerking,
            IsActief,
            DatumAangemaakt,
            DatumGewijzigd
        ) VALUES (
            p_naam,
            p_contact_persoon,
            p_leverancier_nummer,
            p_mobiel,
            p_opmerking,
            1,
            NOW(6),
            NOW(6)
        );
        
        SET p_new_id = LAST_INSERT_ID();
        SET p_success = TRUE;
        SET p_result_message = 'Leverancier succesvol aangemaakt';
    END IF;
END //

DELIMITER ;

