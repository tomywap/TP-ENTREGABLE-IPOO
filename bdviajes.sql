CREATE DATABASE IF NOT EXISTS bdviajes;

USE bdviajes;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    rnombre varchar(150), 
    rapellido  varchar(150), 
    PRIMARY KEY (rnumeroempleado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, 
    vdestino varchar(150),
    vcantmaxpasajeros int,
    idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
    FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pasajero (
    pdocumento varchar(15),
    pnombre varchar(150), 
    papellido varchar(150), 
    ptelefono int, 
    idpasajero bigint AUTO_INCREMENT,
    idviaje bigint,
    PRIMARY KEY (idpasajero),
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE persona(
    pnombre varchar(150), 
    papellido varchar(150),
    pdocumento varchar(15),
    PRIMARY KEY (pdocumento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;