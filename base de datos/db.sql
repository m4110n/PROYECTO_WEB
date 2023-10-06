-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS `botiquin_sa`;

-- Seleccionar la base de datos
USE `botiquin_sa`;


-- creacion de la tabla
create table if not EXISTS users(
	id int not null AUTO_INCREMENT primary key,
    name varchar (20) not null,
    email varchar(50) not null,
    permissions varchar(30) not null,
    password varchar (15) not null,
    status varchar (15) not null) ENGINE=InnoDB;

-- Base de datos para todas las consultas

-- clientes
Create table if not EXISTS Customers(
    Code int not null AUTO_INCREMENT primary key,
    Name varchar (100) not null,
    Status varchar(10) not null,
    Address varchar (180) not null,
    Nit varchar(20) not null,
    Phone varchar(12) not null,
    entry_date DATE NOT NULL,
    exit_date date, -- Consider allowing NULL if applicable
    customer_type varchar (100) not null
)ENGINE=InnoDB;

-- proveedores
CREATE TABLE IF NOT EXISTS Suppliers (
    Code INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Status VARCHAR(10) NOT NULL,
    Address VARCHAR(180) NOT NULL,
    Nit VARCHAR(20) NOT NULL,
    Phone VARCHAR(12) NOT NULL,
    Entry_Date DATE NOT NULL,
    Exit_Date DATE NOT NULL,
    Supplier_Type VARCHAR(100) NOT NULL
)ENGINE=InnoDB;

-- Categorias
CREATE TABLE IF NOT EXISTS Categories (
    Code INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Status VARCHAR(30) NOT NULL,
    Entry_Date DATE NOT NULL,
    Exit_Date DATE NOT NULL
)ENGINE=InnoDB;

-- Medicamentos
CREATE TABLE IF NOT EXISTS Medications (
    Code INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Description VARCHAR(255) NOT NULL,
    Lot VARCHAR(110) NOT NULL,
    Quantity INT NOT NULL,
    Purchase_Price DECIMAL(30, 2) NOT NULL,
    Sale_Price DECIMAL(30, 2) NOT NULL,
    Status VARCHAR(30) NOT NULL,
    Category_Code INT, -- Nueva columna para la clave foránea de Categorías
    Supplier_Code INT, -- Nueva columna para la clave foránea de Suppliers
    Entry_Date DATE NOT NULL,
    Expiry_Date DATE NOT NULL,
    Unit_of_Measure VARCHAR(50) NOT NULL,
    Shelf_Number INT NOT NULL,
    Shelf_Level INT NOT NULL,
    shelf_position_number INT NOT NULL,
    CONSTRAINT FK_Category FOREIGN KEY (Category_Code) REFERENCES Categories(Code),
    CONSTRAINT FK_Supplier FOREIGN KEY (Supplier_Code) REFERENCES Suppliers(Code)
)ENGINE=InnoDB;


-- Ventas
    -- SOLO ES POSIBLE TENER UN AUTO_INCREMENT EN MYSQL
CREATE TABLE IF NOT EXISTS Sales (
    Code INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nit VARCHAR(20) NOT NULL,
    Quantity INT NOT NULL,
    Client_Code INT NOT NULL,
    Client_Name VARCHAR(150) NOT NULL,
    Sale_Date DATE NOT NULL,
    Product VARCHAR(150) NOT NULL,
    Unit_of_Measure VARCHAR(20) NOT NULL,
    Payment_Type VARCHAR(100) NOT NULL,
    Order_Number INT,
    Invoice_Number INT,
    Unit_Price DECIMAL(30, 2) NOT NULL,
    IVA DECIMAL(30, 2) NOT NULL,
    Discount DECIMAL(30, 2) NOT NULL,
    Subtotal DECIMAL(30, 2) NOT NULL,
    Total_Price DECIMAL(40, 2) NOT NULL,
    CONSTRAINT Sales FOREIGN KEY (Client_Code) REFERENCES Customers(Code)
)ENGINE=InnoDB;

-- Crear la tabla para mantener los contadores
CREATE TABLE IF NOT EXISTS CorrelativoCounters (
    Type VARCHAR(20) PRIMARY KEY,
    Counter INT NOT NULL
)ENGINE=InnoDB;

-- Inicializar los contadores
INSERT IGNORE INTO CorrelativoCounters (Type, Counter) VALUES ('Order_Number', 1);
INSERT IGNORE INTO CorrelativoCounters (Type, Counter) VALUES ('Invoice_Number', 1);

-- Crear la función para obtener el próximo correlativo
DELIMITER //
CREATE FUNCTION GetNextCorrelative(type VARCHAR(20)) RETURNS INT
BEGIN
    DECLARE nextCorrelative INT;

    -- Obtener y actualizar el contador
    UPDATE CorrelativoCounters
    SET Counter = Counter + 1
    WHERE Type = type;

    -- Obtener el valor anterior del contador
    SELECT Counter INTO nextCorrelative
    FROM CorrelativoCounters
    WHERE Type = type;

    RETURN nextCorrelative;
END //
DELIMITER ;

