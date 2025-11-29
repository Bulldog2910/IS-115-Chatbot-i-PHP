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
('direction'),
('campus'),
('building'),
('room'),
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
('deadline'),
('semester'),
('assessment'),
('activity'),
('sport'),
('culture'),
('association'),
('event'),
('student'),
('social'),
('course'),
('workshop'),
('meeting'),
('address'),
('Kristiansand'),
('Grimstad'),
('university'),
('uia'),
('parking'),
('space'),
('car'),
('staff'),
('area');


-- 3) categories
INSERT INTO category (categoryDescription) VALUES
('Study Administration'),
('IT and Technical Support'),
('Exams and Assessment'),
('Campus and Student Life'),
('International and Exchange'),
('Health and Counseling');


-- 4) 30 questions with lemma keywords
INSERT INTO questions (questionDescription, questionAnswer, keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7, keyword8, keyword9, keyword10, category)
VALUES
('How do I find my way?', 'Use the map on UiA website or ask at the information desk.', 1,2,3,4,5,6,7,8,9,10,1),
('When are the exams?', 'Exam dates are on Studentweb and in your study plan.', 11,12,13,14,15,16,17,18,19,20,3),
('What activity is available?', 'UiA offers many activities: sport, culture, student association, and social events.', 21,22,23,24,25,26,27,28,29,30,4),
('Where is UiA located?', 'Main campus in Kristiansand, campus in Grimstad.', 31,32,33,34,35,4,1,36,37,38,4),
('Is there parking?', 'Parking spaces available for staff and student; see parking map.', 38,39,40,4,26,41,8,42,43,44,4),
('How can I register for a course?', 'Course registration is done via Studentweb.', 14,28,15,26,13, NULL, NULL, NULL, NULL, NULL,1),
('Where can I find the schedule?', 'The semester schedule is on Studentweb and course page.', 12,19,14,13,28,NULL,NULL,NULL,NULL,NULL,1),
('How do I submit an assignment?', 'Submit your test or assignment through Studentweb.', 16,17,18,14,15,NULL,NULL,NULL,NULL,NULL,1),
('Who can help with IT problem?', 'IT and technical support can assist.', 2,1,7,28, NULL,NULL,NULL,NULL,NULL,NULL,2),
('How do I access Studentweb?', 'Login to Studentweb with your student account.', 14,26,15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2),
('When is the next exam?', 'Check the exam date in Studentweb.', 11,12,14,15,NULL,NULL,NULL,NULL,NULL,NULL,3),
('How many room are available?', 'Rooms can be booked through campus portal.', 6,5,4, NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('Where is the nearest cafe?', 'Campus area has cafe near the building.', 4,5,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How do I join student association?', 'Sign up via the student union.', 26,24,25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How to find direction to building?', 'Use navigation tools or campus map.', 3,5,1,7,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How do I find campus address?', 'Address available on UiA website.', 31,32,30,1,NULL,NULL,NULL,NULL,NULL,NULL,4),
('Where is parking area?', 'Parking area for staff and student is marked.', 38,40,39,4,NULL,NULL,NULL,NULL,NULL,NULL,4),
('Which sport are offered?', 'Sport activities listed on campus portal.', 22,21,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How to participate in event?', 'Sign up for student event.', 25,26,24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('What culture activity is there?', 'Culture and social activities available.', 23,26,27,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How do I contact staff?', 'Staff can be contacted via email or office.', 40,4,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('Where is my room?', 'Check room number in Studentweb.', 6,14,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How to get directions to campus?', 'Follow path or road; use campus map.', 3,8,9,4,1,NULL,NULL,NULL,NULL,NULL,4),
('When is the semester start?', 'Semester start date available on Studentweb.', 19,12,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),
('How do I check deadline?', 'Submission deadline available in course page.', 18,17,19,28,NULL,NULL,NULL,NULL,NULL,NULL,1),
('What workshop is available?', 'Workshop registration is open via Studentweb.', 29,28,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How to schedule meeting?', 'Meeting can be scheduled via Studentweb or email.', 30,28,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),
('Who can I ask about health?', 'Health and counseling services are available.', 2,4, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6),
('How do I find exam location?', 'Check exam room and building via Studentweb.', 11,6,5,14,NULL,NULL,NULL,NULL,NULL,NULL,3),
('Can I get international exchange info?', 'Exchange info available via International office.', 14,4, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5),
('How to access parking map?', 'Parking map available on UiA website.', 1,38,39, NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('What is the submission process?', 'Submission process described in course page.', 17,28,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),
('How can I get student card?', 'Student card issued at information desk.', 26,2, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4),
('How do I report issue?', 'Report problem to IT support.', 2,28,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2);

SET FOREIGN_KEY_CHECKS = 1;