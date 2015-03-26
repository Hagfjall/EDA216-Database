-- Delete the tables if they exist. Set foreign_key_checks = 0 to
-- disable foreign key checks, so the tables may be dropped in
-- arbitrary order.
set foreign_key_checks = 0;
drop table if exists RawMaterials;
drop table if exists Products;
drop table if exists Ingredients;
drop table if exists Customers;
drop table if exists Orders;
drop table if exists PalletDeliveries;
drop table if exists Pallets;
drop table if exists ProductOrders;
set foreign_key_checks = 1;

-- Create the tables.
create table RawMaterials (
rawMaterialName varchar(30),
lastDeliveryDate date NOT null,
lastDeliveryAmount int NOT null,
totalQuantity double NOT null,
unit varchar(30) NOT null,
primary key(rawMaterialName)
);

create table Products (
productName varchar(30),
primary key(productName)
);

create table Ingredients (
ingredientName varchar(30),
productName varchar(30),
quantity double NOT null,
primary key (ingredientName, productName),
foreign key (ingredientName) references RawMaterials(rawMaterialName),
foreign key (productName) references Products(productName)
);

create table Customers (
customerName varchar(30),
address varchar(30),
username varchar(30),
password varchar(30),
primary key (customerName)
);

create table Orders (
orderId int auto_increment,
desiredDeliveryDate date NOT null,
customerName varchar(30) NOT null,
primary key(orderId),
foreign key (customerName) references Customers(customerName)
);

create table Pallets (
palletId int auto_increment,
productionDateTime datetime NOT null DEFAULT NOW(),
state varchar(30) NOT null DEFAULT 'freezer',
blocked bool NOT null DEFAULT false,
productName varchar(30) NOT null,
primary key (palletId),
foreign key (productName) references Products(productName)
);

create table PalletDeliveries (
palletId int,
orderId int,
deliveryDateTime datetime NOT null,
primary key (palletId, orderId),
foreign key (palletId) references Pallets(palletId),
foreign key (orderId) references Orders(orderId)
);

create table ProductOrders (
orderId int,
productName varchar(30),
nbrOfPallets int NOT null,
primary key (orderId, productName),
foreign key (orderId) references Orders(orderId),
foreign key (productName) references Products(productName)
);

-- ADDING SAMPLE DATA INTO DATABASE
-- Adding Products (3)
INSERT INTO Products(productName) VALUES('Nut Ring');
INSERT INTO Products(productName) VALUES('Nut Cookie');
INSERT INTO Products(productName) VALUES('Amneris');

-- Adding Raw materials (for three products)
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Flour', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Butter', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Icing Sugar', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Roasted, chopped nuts', '2000-01-01', 10, 100, 'g');

INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Fine-ground nuts', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Ground, roasted nuts', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Bread crumbs', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Sugar', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Egg Whites', '2000-01-01', 10, 1000, 'dl');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Chocolate', '2000-01-01', 10, 1000, 'g');

INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Marzipan', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Eggs', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Potato starch', '2000-01-01', 10, 1000, 'g');
INSERT INTO RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) VALUES('Wheat flour', '2000-01-01', 10, 1000, 'g');	

-- Adding Ingredients (for 3 products)
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Flour', 'Nut Ring', 450);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Butter', 'Nut Ring', 450);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Icing sugar', 'Nut Ring', 190);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Roasted, chopped nuts', 'Nut Ring', 225);

INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Fine-ground nuts', 'Nut Cookie', 750);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Ground, roasted nuts', 'Nut Cookie', 625);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Bread crumbs', 'Nut Cookie', 125);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Sugar', 'Nut Cookie', 375);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Egg whites', 'Nut Cookie', 3.5);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Chocolate', 'Nut Cookie', 50);

INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Marzipan', 'Amneris', 750);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Butter', 'Amneris', 250);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Eggs', 'Amneris', 250);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Potato starch', 'Amneris', 25);
INSERT INTO Ingredients(ingredientName, productName, quantity) VALUES('Wheat flour', 'Amneris', 25);

-- Adding customers (3)
INSERT INTO Customers(customerName, address, username, password) VALUES('Finkakor AB', 'Helsingborg', 'finkakor', 'password');
INSERT INTO Customers(customerName, address, username, password) VALUES('Småbröd AB', 'Malmö', 'smabrad', 'password');
INSERT INTO Customers(customerName, address, username, password) VALUES('Kaffebröd AB', 'Landskrona', 'kaffebrod', 'password');

-- Adding orders (3/curstomer)
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-03-01', 'Finkakor AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-03-08', 'Finkakor AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-03-15', 'Finkakor AB');

INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-03-15', 'Småbröd AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-04-15', 'Småbröd AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-05-15', 'Småbröd AB');

INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2015-01-01', 'Kaffebröd AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2016-01-01', 'Kaffebröd AB');
INSERT INTO Orders(desiredDeliveryDate, customerName) VALUES('2017-01-01', 'Kaffebröd AB');

-- Adding product orders deliveries (1-1-3/customer)
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(1, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(2, 'Nut Cookie', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(3, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(3, 'Nut Cookie', 2);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(3, 'Amneris', 3);

INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(4, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(5, 'Nut Cookie', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(6, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(6, 'Nut Cookie', 2);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(6, 'Amneris', 3);

INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(7, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(8, 'Nut Cookie', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(9, 'Nut Ring', 1);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(9, 'Nut Cookie', 2);
INSERT INTO ProductOrders(orderId, productName, nbrOfPallets) VALUES(9, 'Amneris', 3);

-- Adding pallets (5/product)
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Ring', '2015-01-01 00:00:00');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Ring', '2015-01-01 00:00:01');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Ring', '2015-01-01 00:00:02');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Ring', '2015-01-01 00:00:03');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Ring', '2015-01-01 00:00:04');

INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Cookie', '2015-01-02 00:00:00');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Cookie', '2015-01-02 00:00:01');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Cookie', '2015-01-02 00:00:02');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Cookie', '2015-01-02 00:00:03');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Nut Cookie', '2015-01-02 00:00:04');

INSERT INTO Pallets(productName, productionDateTime) VALUES('Amneris', '2015-01-03 00:00:00');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Amneris', '2015-01-03 00:00:01');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Amneris', '2015-01-03 00:00:02');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Amneris', '2015-01-03 00:00:03');
INSERT INTO Pallets(productName, productionDateTime) VALUES('Amneris', '2015-01-03 00:00:04');

-- Adding Pallet Deliveries (for 5 orders)
INSERT INTO PalletDeliveries(palletId, orderId, deliveryDateTime) VALUES(1, 1, '2015-03-01 22:00:00');
INSERT INTO PalletDeliveries(palletId, orderId, deliveryDateTime) VALUES(6, 2, '2015-03-08 22:00:00');
INSERT INTO PalletDeliveries(palletId, orderId, deliveryDateTime) VALUES(11, 3, '2015-03-15 22:00:00');
INSERT INTO PalletDeliveries(palletId, orderId, deliveryDateTime) VALUES(2, 4, '2015-03-15 22:11:00');
INSERT INTO PalletDeliveries(palletId, orderId, deliveryDateTime) VALUES(3, 7, '2015-01-01 22:00:00');
UPDATE Pallets SET state = 'delivered' WHERE palletId = 1;
UPDATE Pallets SET state = 'delivered' WHERE palletId = 6;
UPDATE Pallets SET state = 'delivered' WHERE palletId = 11;
UPDATE Pallets SET state = 'delivered' WHERE palletId = 2;
UPDATE Pallets SET state = 'delivered' WHERE palletId = 3;

-- Setting some pallets as blocked
UPDATE Pallets SET blocked = true WHERE palletId = 4;
UPDATE Pallets SET blocked = true WHERE palletId = 5;
UPDATE Pallets SET blocked = true WHERE palletId = 9;
UPDATE Pallets SET blocked = true WHERE palletId = 10;
