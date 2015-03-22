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
name varchar,
lastDeliveryDate date,
lastDeliveryAmmount int,
quantity int,
primary key(name)
);

create table Products (
productName varchar,
primary key(productName)
);

create table Ingredients (
materialName varchar,
productName varchar,
quantity int,
unit int,
primary key (materialName, productName),
foreign key (materialName) references RawMaterials(name),
foreign key (productName) references Products(productName)
);

create table Customers (
name varchar,
address varchar,
username varchar,
password varchar,
primary key (name)
);

create table Orders (
id int auto_increment,
desiredDeliveryDate date,
customerName varchar,
primary key(id),
foreign key (customerName) references Customers(name);
);

create table Pallets (
id int auto_increment,
productionDateTime datetime,
state varchar,
blocked boolean,
productName varchar,
primaty key (id)
foreign key (productName) references Products(productName)
);

create table PalletDeliveries (
palletId int,
orderId int,
deliveryDate date,
primary key (palletId, orderId),
foreign key(palletId) references Pallets(id),
foreign key(orderId) references Orders(id)
);

create table ProductOrders (
orderId int,
productName varchar,
nbrOfPallets int,
primary key (orderId, productName),
foreign key (orderId) references Orders(id),
foreign key (productName) references Products(productName)
);
