-- ============================
-- FAQUiaChatbot SEEDER
-- ============================

USE FAQUiaChatbot;

-- Clear tables in correct order (FK safe)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE questionLog;
TRUNCATE TABLE questions;
TRUNCATE TABLE category;
TRUNCATE TABLE keyWords;
TRUNCATE TABLE chatUser;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================
-- Insert chatUser test data
-- ============================
INSERT INTO chatUser (firstName, lastName, userpassword, mail, username, role)
VALUES
('Fredrik', 'Husebø', 'Passord123@', 'fredrik@gmail.com', 'Husebrah', 'standard'),
('Elias', 'Simonsen', 'Passord123@', 'Elias@gmail.com', 'Gooner', 'standard'),
('Mathias', 'Jorgensen', 'Passord123@', 'Mathias@gmail.com', 'Bulldog', 'standard'),
('Adam', 'Mihn', 'Passord123@', 'Admin@gmail.com', 'Admin', 'admin');


-- ============================
-- Insert categories
-- ============================
INSERT INTO category (categoryDescription)
VALUES 
('Studieadministrasjon'),   -- alt om semesteravgift, studentkort, studieplan
('IT og Teknisk Hjelp'),    -- wifi, eduroam, printing, IT-support
('Eksamen og Vurdering'),   -- eksamenslokasjon, eksamenspålogging
('Campus og Studentliv'),   -- bibliotek, kantine, parkering, campus-informasjon
('Internasjonalt og Utveksling'), -- utveksling og internasjonale spørsmål
('Helse og Rådgivning');    -- psykisk helse, rådgivning


