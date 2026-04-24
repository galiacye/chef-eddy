USE chef_eddy;
CREATE TABLE unites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

INSERT INTO unites (nom) VALUES 
('kg'), ('kilo'), ('kilos'), ('g'), ('gr'), ('grammes'), 
('litre'), ('litres'), ('L'), ('cl'), ('ml'),
 ('tranche'), ('tranches'), ('pièce'), ('pièces');












