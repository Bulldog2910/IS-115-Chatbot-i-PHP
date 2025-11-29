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


-- 2) keyWords
INSERT INTO keyWords (keyword) VALUES
('map'),
('information'),
('directions'),
('campus'),
('buildings'),
('rooms'),
('navigation'),
('path'),
('road'),
('location'),
('exam'),
('date'),
('schedule'),
('studentweb'),
('study'),
('test'),
('submission'),
('deadlines'),
('semester'),
('assessment'),
('activities'),
('sports'),
('culture'),
('association'),
('event'),
('student'),
('social'),
('course'),
('workshop'),
('meetings'),
('address'),
('location'),
('Kristiansand'),
('Grimstad'),
('university'),
('uia'),
('parking'),
('space'),
('cars'),
('student'),
('staff'),
('area'),
('parking');

-- 3) categories
INSERT INTO category (categoryDescription) VALUES
('Study Administration'),
('IT and Technical Support'),
('Exams and Assessment'),
('Campus and Student Life'),
('International and Exchange'),
('Health and Counseling');

-- 4) More questions
INSERT INTO questions (questionDescription, questionAnswer, keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7, keyword8, keyword9, keyword10, category)
VALUES
(
'How do I find my way?',
'You can find your way using the map on UiA’s website or by asking at the information desk.',
1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
NULL
),
(
'When are the exams?',
'You can find the exam dates in the study plan or on Studentweb for your program.',
11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
NULL
),
(
'What activities are available?',
'UiA offers many activities, such as sports, cultural events, student associations, and social gatherings.',
21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
NULL
),
(
'Where is UiA located?',
'The University of Agder has a main campus in Kristiansand and a campus in Grimstad.',
31, 32, 33, 34, 35, 4, 1, 36, 37, 38,
NULL
),
(
'Is there parking available?',
'There are parking spaces at the campus for both staff and students. See the parking map on UiA’s website.',
39, 40, 41, 4, 26, 42, 8, 43, 44, 45,
NULL
);

SET FOREIGN_KEY_CHECKS = 1;
