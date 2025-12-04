# Stored Procedures

This directory contains all stored procedures required for the assignment.

## Installation

To install these stored procedures, run them in your MySQL/MariaDB database:

```bash
mysql -u your_username -p your_database < get_leveranciers_with_product_count.sql
mysql -u your_username -p your_database < get_leverancier_producten.sql
mysql -u your_username -p your_database < add_product_levering.sql
mysql -u your_username -p your_database < get_product_info.sql
```

Or execute them directly in phpMyAdmin or your MySQL client.

## Stored Procedures

### User Story Procedures:
1. **GetLeveranciersWithProductCount()** - Returns all suppliers with count of different products they supply, sorted by product count descending.

2. **GetLeverancierProducten(p_leverancier_id)** - Returns products delivered by a specific supplier with warehouse amounts and last delivery date, sorted by warehouse amount descending.

3. **AddProductLevering(...)** - Adds a new delivery record and updates warehouse stock. Returns error if product is not active.

4. **GetProductInfo(p_product_id)** - Returns product information including IsActief status.

### CRUD Procedures:
5. **CreateLeverancier(...)** - Creates a new leverancier. Returns error if leverancier number already exists.

6. **UpdateLeverancier(...)** - Updates an existing leverancier. Returns error if leverancier number conflicts.

7. **DeleteLeverancier(p_id)** - Deletes (or deactivates) a leverancier. Soft delete if has products, hard delete if no products.

