-- Stored Procedure: Get product information including IsActief status
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS GetProductInfo(IN p_product_id INT)
BEGIN
    SELECT 
        id,
        naam,
        barcode,
        IsActief
    FROM products
    WHERE id = p_product_id;
END //

DELIMITER ;

