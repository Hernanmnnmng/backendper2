-- Stored Procedure: Get all suppliers with count of different products they supply
-- Sorted by product count descending
DELIMITER //

CREATE PROCEDURE IF NOT EXISTS GetLeveranciersWithProductCount()
BEGIN
    SELECT 
        l.id,
        l.naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
    FROM leveranciers l
    LEFT JOIN product_per_leverancier ppl ON l.id = ppl.LeverancierId
    WHERE l.IsActief = 1
    GROUP BY l.id, l.naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalVerschillendeProducten DESC;
END //

DELIMITER ;

