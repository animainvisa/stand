CREATE DATABASE stand CHARACTER SET latin1;

CREATE TABLE vehicles ( 
	id_vehicle INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	
	/*****/
	make VARCHAR(100) NOT NULL, 
	model VARCHAR(100) NOT NULL, 
	version VARCHAR(100) NOT NULL,
	year VARCHAR(100) NOT NULL,	
	engine VARCHAR(100) NOT NULL,
	fuel VARCHAR(100) NOT NULL, 
	price VARCHAR(100) NOT NULL, 
	category VARCHAR(100) NOT NULL, 
	body VARCHAR(100) NOT NULL, 
	color	VARCHAR(100) NOT NULL,
	kilometres VARCHAR(100) NOT NULL,	
	regplate VARCHAR(100) NOT NULL, 	
	
	section ENUM('Novos', 'Usados') NOT NULL, 
	features TEXT NOT NULL, 
	/*****/
	 
	PRIMARY KEY (id_vehicle)
) ENGINE=INNODB, AUTO_INCREMENT=1000, CHARACTER SET latin1;

CREATE TABLE images ( 
	id_image INT UNSIGNED NOT NULL AUTO_INCREMENT,  
	image_data MEDIUMBLOB NOT NULL, 
	image_type TINYINT NOT NULL, 
	primary_image INT UNSIGNED NOT NULL, 
	id_vehicle INT UNSIGNED NOT NULL, 
	PRIMARY KEY (id_image), 
	INDEX (id_vehicle), 
	FOREIGN KEY (id_vehicle) 
		REFERENCES vehicles (id_vehicle) 
		ON UPDATE CASCADE ON DELETE CASCADE 
) ENGINE=INNODB, AUTO_INCREMENT=1000;
