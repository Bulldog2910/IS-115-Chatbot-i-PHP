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
SET FOREIGN_KEY_CHECKS = 1;

-- 1) chatUser
INSERT INTO chatUser (firstName, lastName, userpassword, mail, username, role) VALUES
('Fredrik', 'Husebø',  'Passord123@', 'fredrik@gmail.com', 'Husebrah', 'standard'),
('Elias',   'Simonsen','Passord123@', 'Elias@gmail.com',   'Gooner',   'standard'),
('Mathias', 'Jorgensen','Passord123@','Mathias@gmail.com', 'Bulldog',  'standard'),
('Adam',    'Mihn',    'Passord123@', 'Admin@gmail.com',   'Admin',    'admin');

-- 2) keyWords
INSERT INTO keyWords (keyword) VALUES
('how'),
('book'),
('meeting'),
('grading');

-- 3) categories
INSERT INTO category (categoryDescription) VALUES
('Studieadministrasjon'),
('IT og Teknisk Hjelp'),
('Eksamen og Vurdering'),
('Campus og Studentliv'),
('Internasjonalt og Utveksling'),
('Helse og Rådgivning');

-- 4) questions
INSERT INTO questions (
    questionDescription, questionAnswer,
    keyword1, keyword2, keyword3,
    category
) VALUES
(
    'Hvordan booker jeg tid, til intervju i IS-115?',
    'Du må booke tid igjennom BookIT',
    1, 2, 3,
    2
);
