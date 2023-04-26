CREATE DATABASE mensa;
USE mensa;

CREATE TABLE IF NOT EXISTS utenti  (
    id int(11) NOT NULL AUTO_INCREMENT,
    nome varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    psw VARCHAR(41) NOT NULL,
    livello int(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS ingredienti (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(50) NOT NULL,
    quantita DECIMAL(11,2) DEFAULT NULL,
    misura varchar(10) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS piatti (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(50) DEFAULT NULL,
    quantita DECIMAL(11,2) DEFAULT NULL,
    misura varchar(10) DEFAULT NULL,
    quantita_servita DECIMAL(5,2) DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS piatti_ingredienti (
    id_piatto INT NOT NULL,
    id_ingrediente INT NOT NULL,
    quantita DECIMAL(11,2) NOT NULL,
    FOREIGN KEY (id_piatto) REFERENCES piatti(id),
    FOREIGN KEY (id_ingrediente) REFERENCES ingredienti(id),
    PRIMARY KEY (id_piatto, id_ingrediente)
);

INSERT INTO utenti (nome, username, psw, livello) VALUES
("Filippo", "filippo", PASSWORD("123"), 1),
("Gianni", "gianni", PASSWORD("123"), 1),
("Tonno", "tonnaccio", PASSWORD("123"), 1),
("Chef Cannavacciuolo", "ChefC", PASSWORD("123"), 2),
("Chef Locatelli", "ChefL", PASSWORD("123"), 2),
("Admin", "admin", PASSWORD("admin"), 3);

INSERT INTO ingredienti (nome, quantita, misura) VALUES
("farina", 10000, "g"),
("sale", 10000, "g"),
("zucchero", 10000, "g"),
("uova", 100, "pezzi"),
("salsa di pomodoro", 100, "L"),
("pasta", 100000, "g");

INSERT INTO piatti (nome, quantita, misura, quantita_servita) VALUES
("pasta al sugo", 100, "g", 50),
("pizza", 10, "pezzi", 1),
("focaccia", 10, "pezzi", 1);

INSERT INTO piatti_ingredienti (id_piatto, id_ingrediente, quantita) VALUES
(1, 6, 100),
(1, 2, 5),
(1, 5, 0.1),
(2, 1, 100),
(2, 5, 0.2),
(2, 2, 10),
(3, 4, 1),
(3, 3, 50);