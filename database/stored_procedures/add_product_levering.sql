-- Stored Procedure: Add a new delivery and update warehouse stock
-- Returns error message if product is not active
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS AddProductLevering(
    IN p_leverancier_id INT,
    IN p_product_id INT,
    IN p_aantal INT,
    IN p_datum_levering DATE,
    IN p_datum_eerstvolgende_levering DATE,
    OUT p_result_message VARCHAR(255),
    OUT p_success BOOLEAN
)
BEGIN
    DECLARE v_product_actief BOOLEAN;
    DECLARE v_current_stock INT;
    DECLARE v_warehouse_exists INT;
    
    -- Check if product is active
    SELECT IsActief INTO v_product_actief
    FROM products
    WHERE id = p_product_id;
    
    IF v_product_actief = 0 THEN
        SET p_success = FALSE;
        SET p_result_message = CONCAT('Het product wordt niet meer geproduceerd');
    ELSE
        -- Check if warehouse record exists
        SELECT COUNT(*) INTO v_warehouse_exists
        FROM magazijn
        WHERE ProductId = p_product_id;
        
        -- Get current warehouse stock
        IF v_warehouse_exists > 0 THEN
            SELECT AantalAanwezig INTO v_current_stock
            FROM magazijn
            WHERE ProductId = p_product_id;
        ELSE
            SET v_current_stock = 0;
        END IF;
        
        -- Insert new delivery record
        INSERT INTO product_per_leverancier (
            LeverancierId,
            ProductId,
            DatumLevering,
            Aantal,
            DatumEerstVolgendeLevering,
            IsActief,
            DatumAangemaakt,
            DatumGewijzigd
        ) VALUES (
            p_leverancier_id,
            p_product_id,
            p_datum_levering,
            p_aantal,
            p_datum_eerstvolgende_levering,
            1,
            NOW(6),
            NOW(6)
        );
        
        -- Update or create warehouse record
        IF v_warehouse_exists > 0 THEN
            -- Update existing warehouse stock
            UPDATE magazijn
            SET AantalAanwezig = COALESCE(v_current_stock, 0) + p_aantal,
                DatumGewijzigd = NOW(6)
            WHERE ProductId = p_product_id;
        ELSE
            -- Create new warehouse record with default VerpakkingsEenheid
            INSERT INTO magazijn (
                ProductId,
                VerpakkingsEenheid,
                AantalAanwezig,
                IsActief,
                DatumAangemaakt,
                DatumGewijzigd
            ) VALUES (
                p_product_id,
                1.0, -- Default packaging unit
                p_aantal,
                1,
                NOW(6),
                NOW(6)
            );
        END IF;
        
        SET p_success = TRUE;
        SET p_result_message = 'Levering succesvol toegevoegd';
    END IF;
END //

DELIMITER ;

