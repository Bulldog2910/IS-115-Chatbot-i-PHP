-- Create database
-- CREATE DATABASE IF NOT EXISTS FAQUiaChatbot;
-- USE FAQUiaChatbot;

-- Drop existing tables
DROP TABLE IF EXISTS questionLog, questions, category, keyWords, chatUser;

-- chatUser table
CREATE TABLE chatUser (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(60),
    lastName VARCHAR(60),
    userpassword VARCHAR(255) NOT NULL,
    mail VARCHAR(60) NOT NULL,
    username VARCHAR(40) NOT NULL,
    role ENUM('standard', 'admin') DEFAULT 'standard'
);

-- keyWords table
CREATE TABLE keyWords (
    keywordId INT AUTO_INCREMENT PRIMARY KEY,
    keyword VARCHAR(40) NOT NULL 
);

-- category table
CREATE TABLE category (
    categoryId INT AUTO_INCREMENT PRIMARY KEY,
    categoryDescription VARCHAR(40) NOT NULL
);

-- questions table
CREATE TABLE questions (
    questionId INT AUTO_INCREMENT PRIMARY KEY,
    questionDescription VARCHAR(400) NOT NULL,
    questionAnswer VARCHAR(400) NOT NULL,
    keyword1 INT,
    keyword2 INT,
    keyword3 INT,
    keyword4 INT,
    keyword5 INT,
    keyword6 INT,
    keyword7 INT,
    keyword8 INT,
    keyword9 INT,
    keyword10 INT,
    category INT,
    FOREIGN KEY (keyword1) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword2) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword3) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword4) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword5) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword6) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword7) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword8) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword9) REFERENCES keyWords(keywordId),
    FOREIGN KEY (keyword10) REFERENCES keyWords(keywordId),
    FOREIGN KEY (category) REFERENCES category(categoryId)
);

-- questionLog table
CREATE TABLE questionLog (
    logId INT AUTO_INCREMENT PRIMARY KEY,
    questionId INT NOT NULL,
    userId INT NOT NULL,
    questionLogTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (questionId) REFERENCES questions(questionId),
    FOREIGN KEY (userId) REFERENCES chatUser(userId)
);


