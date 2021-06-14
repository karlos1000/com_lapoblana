DROP TABLE IF EXISTS `#__lapoblana`;
DROP TABLE IF EXISTS `#__orderslp`;
DROP TABLE IF EXISTS `#__productslp`;
DROP TABLE IF EXISTS `#__cat_customerslp`;
DROP TABLE IF EXISTS `#__cat_productslp`;
DROP TABLE IF EXISTS `#__cat_statuslp`;
DROP TABLE IF EXISTS `#__cat_drawingslp`;

 
CREATE TABLE `#__lapoblana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `greeting` varchar(25) NOT NULL,
  `fileContent` TEXT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 
INSERT INTO `#__lapoblana` (`greeting`) VALUES
        ('Hola Mundo!'),
        ('Adios Mundo!');

CREATE TABLE `#__orderslp` (
  `idOrder` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` int(11) NOT NULL,
  `idCustomer` varchar(50) NULL,
  `dateOrder` date NULL COMMENT 'Fecha de orden',
  `dateReceipt` date NULL COMMENT 'Fecha de recepcion',
  `weeks` DOUBLE (11,1) NOT NULL COMMENT 'Numero de semanas estimadas',
  `dateEstimated` date NULL COMMENT 'Fecha estimada',
          
  PRIMARY KEY  (`idOrder`)      
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;		
		
CREATE TABLE `#__productslp` (
  `prodId` int(11) NOT NULL AUTO_INCREMENT,
  `orderNum` int(11) NOT NULL,
  `prodName` int(11) NULL COMMENT 'Nombre de producto', 
  `prodDrawing` int(11) NULL COMMENT 'Dibujo', 
  `prodImg` varchar(150) NULL COMMENT 'Nombre de la imagen',   
  `amount` int(11) NOT NULL COMMENT 'Cantidad', 
  `whoRequested` varchar(80) NULL COMMENT 'Nombre de quien solicito',   
  `status` int(11) NULL COMMENT 'Estado de la orden',
  `cloth` varchar(30) NULL COMMENT 'Tela',   
  `weaveCloth` varchar(30) NULL COMMENT 'Tela por tejer',   
  `dateStock` date NULL COMMENT 'Fecha de entrega en almacen',    
  
   PRIMARY KEY  (`prodId`)      
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__cat_customerslp` (
  `customerId` int(11) NOT NULL AUTO_INCREMENT,  
  `customerName` varchar(100) NOT NULL,  
  `userIdJoomla` varchar(10) NULL,    
  `active` CHAR( 1 ) NOT NULL DEFAULT  '1',
  `dateCreation` date NULL COMMENT 'Fecha de creacion de usuario en el catalogo',

  PRIMARY KEY  (`customerId`)       
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__cat_productslp` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(70) NOT NULL,
  `active` CHAR( 1 ) NOT NULL DEFAULT  '1',
  `dateCreation` date NULL COMMENT 'Fecha de creacion del producto',

   PRIMARY KEY  (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__cat_statuslp` (
  `statusId` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(70) NOT NULL,
  `active` CHAR( 1 ) NOT NULL DEFAULT  '1',
  `dateCreation` date NULL COMMENT 'Fecha de creacion del estatus',

   PRIMARY KEY  (`statusId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__cat_drawingslp` (
  `drawingId` int(11) NOT NULL AUTO_INCREMENT,
  `drawingName` varchar(70) NOT NULL,
  `active` CHAR( 1 ) NOT NULL DEFAULT  '1',
  `dateCreation` date NULL COMMENT 'Fecha de creacion del dibujo',

   PRIMARY KEY  (`drawingId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
