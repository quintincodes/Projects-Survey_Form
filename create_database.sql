-- Create database
CREATE DATABASE IF NOT EXISTS survey_db;

-- Use the database
USE survey_db;

-- Create table for survey responses
CREATE TABLE IF NOT EXISTS survey_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(100),
    role VARCHAR(50),
    picture_path VARCHAR(255),
    learning_preference VARCHAR(50),
    ai_usage VARCHAR(50),
    library_relevance VARCHAR(50),
    opinion TEXT,
    tools TEXT,
    learning_resources TEXT,
    future TEXT,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Display confirmation
SELECT 'Database and table created successfully!' AS Message;
