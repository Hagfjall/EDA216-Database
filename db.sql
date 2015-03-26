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
lastDeliveryDate date,
lastDeliveryAmount int,
totalQuantity int,
unit varchar(30),
primary key(rawMaterialName)
);

create table Products (
productName varchar(30),
primary key(productName)
);

create table Ingredients (
ingredientName varchar(30),
productName varchar(30),
quantity int,
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
desiredDeliveryDate date,
customerName varchar(30),
primary key(orderId),
foreign key (customerName) references Customers(customerName)
);

create table Pallets (
palletId int auto_increment,
productionDateTime datetime not null default NOW(),
state varchar(30),
blocked bool default false,
productName varchar(30),
primary key (palletId),
foreign key (productName) references Products(productName)
);

create table PalletDeliveries (
palletId int,
orderId int,
deliveryDateTime datetime,
primary key (palletId, orderId),
foreign key (palletId) references Pallets(palletId),
foreign key (orderId) references Orders(orderId)
);

create table ProductOrders (
orderId int,
productName varchar(30),
nbrOfPallets int,
primary key (orderId, productName),
foreign key (orderId) references Orders(orderId),
foreign key (productName) references Products(productName)
);

-- Adding Products
insert into Products(productName) values('Nut Ring');
insert into Products(productName) values('Nut Cookie');
insert into Products(productName) values('Amneris');

-- Adding Raw materials
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Flour', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Butter', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Icing Sugar', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Roasted, chopped nuts', '2000-01-01', 10, 100, 'g');

insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Fine-ground nuts', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Ground, roasted nuts', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Bread crumbs', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Sugar', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Egg Whites', '2000-01-01', 10, 1000, 'dl');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Chocolate', '2000-01-01', 10, 1000, 'g');

insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Marzipan', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Potato starch', '2000-01-01', 10, 1000, 'g');
insert into RawMaterials(rawMaterialName, lastDeliveryDate, lastDeliveryAmount, totalQuantity, unit) values('Wheat flour', '2000-01-01', 10, 1000, 'g');	

-- Adding Ingredients
insert into Ingredients(ingredientName, productName, quantity) values('Flour', 'Nut Ring', 450);
insert into Ingredients(ingredientName, productName, quantity) values('Butter', 'Nut Ring', 450);
insert into Ingredients(ingredientName, productName, quantity) values('Icing sugar', 'Nut Ring', 190);
insert into Ingredients(ingredientName, productName, quantity) values('Roasted, chopped nuts', 'Nut Ring', 225);

insert into Ingredients(ingredientName, productName, quantity) values('Fine-ground nuts', 'Nut Cookie', 225);
insert into Ingredients(ingredientName, productName, quantity) values('Ground, roasted nuts', 'Nut Cookie', 225);
insert into Ingredients(ingredientName, productName, quantity) values('Bread crumbs', 'Nut Cookie', 225);
insert into Ingredients(ingredientName, productName, quantity) values('Sugar', 'Nut Cookie', 225);
insert into Ingredients(ingredientName, productName, quantity) values('Whites', 'Nut Cookie', 225);
insert into Ingredients(ingredientName, productName, quantity) values('Roasted, chopped nuts', 'Nut Cookie	', 225);




insert into Customers(customerName, address, username, password) values('Finkakor AB', 'Helsingborg', 'finkakor', 'password');
insert into Orders(desiredDeliveryDate, customerName) values('2000-01-01', 'Finkakor AB');
insert into Orders(desiredDeliveryDate, customerName) values('2015-04-01', 'Finkakor AB');
insert into Orders(desiredDeliveryDate, customerName) values('2015-05-01', 'Finkakor AB');
insert into Pallets(state, productName) values('freezer', 'Nut Ring');
insert into Pallets(state, productName) values('freezer', 'Nut Ring');
insert into Pallets(state, productName) values('freezer', 'Nut Ring');
insert into Pallets(state, productName) values('freezer', 'Nut Ring');
insert into Pallets(state, productName) values('freezer', 'Nut Ring');
insert into PalletDeliveries(palletId, orderId, deliveryDateTime) values(2, 1, '2015-03-23 22:00:00');
insert into PalletDeliveries(palletId, orderId, deliveryDateTime) values(3, 2, '2015-03-23 22:00:00');
insert into PalletDeliveries(palletId, orderId, deliveryDateTime) values(4, 2, '2015-03-24 22:00:00');
insert into PalletDeliveries(palletId, orderId, deliveryDateTime) values(5, 2, '2015-03-25 22:00:00');
insert into ProductOrders(orderId, productName, nbrOfPallets) values(1, 'Nut Ring', 1000);
insert into ProductOrders(orderId, productName, nbrOfPallets) values(2, 'Nut Ring', 3);
insert into ProductOrders(orderId, productName, nbrOfPallets) values(3, 'Nut Ring', 2);
