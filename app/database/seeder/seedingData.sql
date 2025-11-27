-- ============================
-- FAQUiaChatbot SEEDER
-- ============================

USE FAQUiaChatbot;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE questionLog;
TRUNCATE TABLE questions;
TRUNCATE TABLE category;
TRUNCATE TABLE keyWords;
TRUNCATE TABLE chatUser;


-- 1) chatUser
INSERT INTO chatUser (firstName, lastName, userpassword, mail, username, role) VALUES
('Fredrik', 'Husebø',  'Passord123@', 'fredrik@gmail.com', 'Husebrah', 'standard'),
('Elias',   'Simonsen','Passord123@', 'Elias@gmail.com',   'Gooner',   'standard'),
('Mathias', 'Jorgensen','Passord123@','Mathias@gmail.com', 'Bulldog',  'standard'),
('Adam',    'Mihn',    'Passord123@', 'Admin@gmail.com',   'Admin',    'admin');

-- 2) keyWords
INSERT INTO keyWords (keyword) VALUES
('kart'),
('informasjon'),
('veibeskrivelse'),
('campus'),
('bygninger'),
('rom'),
('navigasjon'),
('sti'),
('vei'),
('plassering'),
('eksamen'),
('dato'),
('timeplan'),
('studentweb'),
('studieplan'),
('prøve'),
('innlevering'),
('frister'),
('semester'),
('vurdering'),
('aktiviteter'),
('idrett'),
('kultur'),
('forening'),
('arrangement'),
('studentliv'),
('sosialt'),
('kurs'),
('workshop'),
('møter'),
('adresse'),
('lokasjon'),
('Kristiansand'),
('Grimstad'),
('universitet'),
('uia'),
('parkering'),
('plass'),
('biler'),
('student'),
('ansatt'),
('område'),
('P-hus');


-- 3) categories
INSERT INTO category (categoryDescription) VALUES
('Studieadministrasjon'),
('IT og Teknisk Hjelp'),
('Eksamen og Vurdering'),
('Campus og Studentliv'),
('Internasjonalt og Utveksling'),
('Helse og Rådgivning');


-- 4) More questions
INSERT INTO questions (questionDescription, questionAnswer, keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7, keyword8, keyword9, keyword10, category)
VALUES
(
    'Hvordan finner jeg fram?', 
    'Du kan finne fram ved å bruke kartet på UiA sin nettside eller spørre i informasjonsskranken.', 
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
    NULL
),
(
    'Når er eksamen?', 
    'Eksamensdatoene finner du i studieplanen eller på studentweb for ditt program.', 
    11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
    NULL
),
(
    'Hvilke aktiviteter finnes?', 
    'UiA tilbyr mange aktiviteter, som idrett, kulturarrangementer, studentforeninger og sosiale treff.', 
    21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
    NULL
),
(
    'Hvor ligger Uia?', 
    'Universitetet i Agder har hovedcampus i Kristiansand og en campus i Grimstad.', 
    31, 32, 33, 34, 35, 4, 1, 36, 37, 38,
    NULL
),
(
    'Finnes det parkeringsplass?', 
    'Det finnes parkeringsplasser ved campus, både for ansatte og studenter. Se parkeringskart på UiA sin nettside.', 
    39, 40, 41, 4, 26, 42, 8, 43, 44, 45,
    NULL
);

SET FOREIGN_KEY_CHECKS = 1;

