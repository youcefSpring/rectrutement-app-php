-- Table for candidates
CREATE TABLE candidat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NULL,
    prenom VARCHAR(255) NULL,
    email VARCHAR(255) UNIQUE NULL,
    telephone VARCHAR(255) NULL,
    adresse TEXT NULL
);

-- Table for agents
CREATE TABLE agent (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NULL,
    prenom VARCHAR(255) NULL,
    email VARCHAR(255) UNIQUE NULL,
    telephone VARCHAR(255) NULL,
    password VARCHAR(255) null
);

-- Table for job announcements
CREATE TABLE annonce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre_poste VARCHAR(255) NULL,
    date_expiration DATE NULL,
    dernier_delai_inscription DATE NULL,
    conditions TEXT NULL
);

-- Table for job offers with foreign keys
CREATE TABLE offre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    annonce_id INT,
    candidat_id INT,
    status ENUM('0', '1', '2') DEFAULT '2',
    FOREIGN KEY (annonce_id) REFERENCES annonce(id),
    FOREIGN KEY (candidat_id) REFERENCES candidat(id)
);


-- Insert test data into candidat table with Algerian names
INSERT INTO candidat (nom, prenom, email, telephone, adresse) VALUES
('Belaid', 'Khaled', 'khaled.belaid@example.com', '0212345678', '123 Rue Didouche Mourad, Alger'),
('Benhamou', 'Nadia', 'nadia.benhamou@example.com', '0551234567', '456 Avenue de la République, Oran'),
('Chabane', 'Sofiane', 'sofiane.chabane@example.com', '0776543210', '789 Boulevard de l’Indépendance, Constantine');

-- Insert test data into agent table with Algerian names
INSERT INTO agent (nom, prenom, email, telephone) VALUES
('Mekki', 'Ahmed', 'ahmed.mekki@example.com', '0219876543'),
('Zidane', 'Fatima', 'fatima.zidane@example.com', '0559876543'),
('Ait Ahmed', 'Rachid', 'rachid.aitahmed@example.com', '0771234567');

-- Insert test data into annonce table
INSERT INTO annonce (titre_poste, date_expiration, dernier_delai_inscription, conditions) VALUES
('Développeur Java', '2024-12-31', '2024-11-30', 'Expérience en Java et SQL requise.'),
('Analyste Marketing', '2024-11-30', '2024-10-15', 'Expérience en analyse de marché et outils de CRM.'),
('Responsable RH', '2024-10-31', '2024-09-30', 'Expérience en gestion des ressources humaines et recrutement.');

-- Insert test data into offre table
INSERT INTO offre (annonce_id, candidat_id, status) VALUES
(1, 1, '1'), -- Offre acceptée pour Développeur Java par Khaled Belaid
(2, 2, '0'), -- Offre non acceptée pour Analyste Marketing par Nadia Benhamou
(3, 3, '2'); -- Offre en attente pour Responsable RH par Sofiane Chabane
