
USE TapCheck;

INSERT IGNORE INTO Ingredent
VALUES (1, 'Lettuce');
INSERT IGNORE INTO Ingredent
VALUES (2, 'Cheese');
INSERT IGNORE INTO Ingredent
VALUES (3, 'Chicken');
INSERT IGNORE INTO Ingredent
VALUES (4, 'Salad dressing');
INSERT IGNORE INTO Ingredent
VALUES (5, 'Crouton');
INSERT IGNORE INTO Location(name)
VALUES ('Loblaws');
INSERT IGNORE INTO Location (name)
VALUES ('Independent');
INSERT IGNORE INTO Location (name)
VALUES ('Farmboy');
INSERT IGNORE INTO Location (name)
VALUES ('Metro');
INSERT IGNORE INTO Product (product_id, nfc_id, description, tag)
VALUES (1, '56sh3', 'Salad', 'produce');
INSERT IGNORE INTO Product_Ingredent
VALUES (1,1);
INSERT IGNORE INTO Product_Ingredent
VALUES (1,2);
INSERT IGNORE INTO Product_Ingredent
VALUES (1,3);
INSERT IGNORE INTO Product_Ingredent
VALUES (1,4);
INSERT IGNORE INTO Product_Ingredent
VALUES (1,5);
INSERT IGNORE INTO Product_Location
VALUES (1,1);
INSERT IGNORE INTO Product_Ingredent
VALUES (1,2);
INSERT IGNORE INTO Restriction
VALUES (1,'Poultry', 1);
INSERT IGNORE INTO Restriction_Ingredent 
VALUES (1,3);
