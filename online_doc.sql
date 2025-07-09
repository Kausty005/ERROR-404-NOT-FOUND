CREATE DATABASE hospital_db;
USE hospital_db;

CREATE TABLE online_appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_name VARCHAR(100),
    patient_email VARCHAR(100),
    doctor_name VARCHAR(100),
    time_slot VARCHAR(20),
    meeting_link VARCHAR(255),
    status VARCHAR(20)
);



-- Create the table
CREATE TABLE doctor_meet_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_name VARCHAR(100) NOT NULL,
    link VARCHAR(255) NOT NULL
);

-- Insert sample data
INSERT INTO doctor_meet_links (doctor_name, link)
VALUES 
 ('Dr. Abhay Kulkarni', 'https://meet.google.com/wuz-odro-svd'),
 ('Dr. Mohan Joshi', 'https://meet.google.com/wdh-nnsi-mis'),
 ('Dr. Abhinav Shinde', 'https://meet.google.com/rjc-ibix-aob'),
 ('Dr. Harsh Gaikwad', 'https://meet.google.com/hrx-ttrx-bkp');



-- Create the table
CREATE TABLE online_doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

INSERT INTO online_doctors (id, name, email)
VALUES
(1, 'Dr. Abhay Kulkarni', 'katareomkar.28@gmail.com'),
(2, 'Dr. Mohan Joshi', 'riyagupta17jee@gmail.com'),
(3, 'Dr. Abhinav Shinde', 'srishti01.gupta08@gmail.com'),
(4, 'Dr. Harsh Gaikwad', 'kaustubhgulwade@gmail.com');




