-- Stored Procedure: Get products delivered by a specific supplier
-- With warehouse amount and last delivery date
-- Sorted by warehouse amount descending
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS GetLeverancierProducten(IN p_leverancier_id INT)
BEGIN
    SELECT 
        p.id AS ProductId,
        p.naam AS ProductNaam,
        p.barcode,
        p.IsActief AS ProductIsActief,
        COALESCE(m.AantalAanwezig, 0) AS AantalInMagazijn,
        MAX(ppl.DatumLevering) AS LaatsteLevering
    FROM products p
    INNER JOIN product_per_leverancier ppl ON p.id = ppl.ProductId
    LEFT JOIN magazijn m ON p.id = m.ProductId
    WHERE ppl.LeverancierId = p_leverancier_id
    GROUP BY p.id, p.naam, p.barcode, p.IsActief, m.AantalAanwezig
    ORDER BY AantalInMagazijn DESC;
END //

DELIMITER ;

