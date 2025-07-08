

CREATE DATABASE IF NOT EXISTS HospitalDB;
USE HospitalDB;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS hospitals;


-- Create hospitals table
CREATE TABLE hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    speciality VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    beds_total INT DEFAULT 50,
    beds_available INT DEFAULT 25,
    emergency_services BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT,
    name VARCHAR(255) NOT NULL,
    speciality VARCHAR(100) NOT NULL,
    experience_years INT DEFAULT 5,
    availability_status ENUM('available', 'busy', 'off_duty') DEFAULT 'available',
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id) ON DELETE CASCADE
);


CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT,
    hospital_name VARCHAR(255) NOT NULL,
    patient_name VARCHAR(255) DEFAULT 'Emergency Patient',
    patient_phone VARCHAR(20) DEFAULT '+91-9999999999',
    emergency_type VARCHAR(100) NOT NULL,
    speciality_needed VARCHAR(100) NOT NULL,
    injury_type VARCHAR(100) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    booking_time DATETIME NOT NULL,
    appointment_time DATETIME,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'confirmed',
    booking_reference VARCHAR(50),
    latitude DECIMAL(10, 8) DEFAULT 0,
    longitude DECIMAL(11, 8) DEFAULT 0,
    distance_km DECIMAL(5, 2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id) ON DELETE SET NULL
);



CREATE INDEX idx_hospitals_speciality ON hospitals(speciality);
CREATE INDEX idx_hospitals_location ON hospitals(latitude, longitude);
CREATE INDEX idx_doctors_speciality ON doctors(speciality);
CREATE INDEX idx_doctors_hospital ON doctors(hospital_id);
CREATE INDEX idx_bookings_hospital_id ON bookings(hospital_id);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_bookings_date ON bookings(booking_date);
CREATE INDEX idx_bookings_reference ON bookings(booking_reference);

-- =====================================================
-- INSERT HOSPITAL DATA


INSERT INTO hospitals (name, latitude, longitude, speciality, address, phone, email, beds_total, beds_available) VALUES
-- Cardiologist Hospitals
('Apollo Heart Institute', 28.6139, 77.2090, 'Cardiologist', 'Sector 26, Noida, Delhi NCR', '+91-120-4567890', 'info@apolloheart.com', 80, 45),
('Fortis Heart Center', 28.5355, 77.3910, 'Cardiologist', 'Sector 62, Noida, Delhi NCR', '+91-120-4567891', 'care@fortisheart.com', 60, 30),
('Max Heart Hospital', 28.4595, 77.0266, 'Cardiologist', 'Gurgaon, Haryana', '+91-124-4567892', 'contact@maxheart.com', 70, 35),

-- Neurologist Hospitals
('AIIMS Neurology Center', 28.5672, 77.2100, 'Neurologist', 'Ansari Nagar, New Delhi', '+91-11-26588500', 'neuro@aiims.edu', 100, 60),
('Medanta Neurosciences', 28.4089, 77.0428, 'Neurologist', 'Sector 38, Gurgaon', '+91-124-4141414', 'neuro@medanta.org', 90, 50),
('BLK Neuro Hospital', 28.6692, 77.2265, 'Neurologist', 'Pusa Road, New Delhi', '+91-11-30403040', 'info@blkneuro.com', 75, 40),

-- Orthopedist Hospitals
('Indian Spinal Injuries Centre', 28.5706, 77.2137, 'Orthopedist', 'Sector C, Vasant Kunj, New Delhi', '+91-11-42255225', 'info@isiconline.org', 120, 70),
('Bone & Joint Hospital', 28.6304, 77.2177, 'Orthopedist', 'Lajpat Nagar, New Delhi', '+91-11-29834567', 'care@bonejoint.com', 80, 45),
('Max Orthopedic Center', 28.5245, 77.1855, 'Orthopedist', 'Saket, New Delhi', '+91-11-26515050', 'ortho@maxhealthcare.com', 85, 50),

-- Emergency Physician Hospitals
('All India Institute of Medical Sciences', 28.5672, 77.2100, 'Emergency Physician', 'Ansari Nagar, New Delhi', '+91-11-26588700', 'emergency@aiims.edu', 150, 80),
('Safdarjung Hospital', 28.5706, 77.2137, 'Emergency Physician', 'Ansari Nagar West, New Delhi', '+91-11-26165060', 'emergency@safdarjung.gov.in', 200, 100),
('Ram Manohar Lohia Hospital', 28.6358, 77.2244, 'Emergency Physician', 'Baba Kharak Singh Marg, New Delhi', '+91-11-23404040', 'rml@gov.in', 180, 90),

-- General Surgeon Hospitals
('Sir Ganga Ram Hospital', 28.6358, 77.2244, 'General Surgeon', 'Rajinder Nagar, New Delhi', '+91-11-25750000', 'info@sgrh.com', 100, 55),
('Maulana Azad Medical College', 28.6507, 77.2334, 'General Surgeon', 'Bahadur Shah Zafar Marg, New Delhi', '+91-11-23239271', 'mamc@gov.in', 120, 65),
('Hindu Rao Hospital', 28.6692, 77.2265, 'General Surgeon', 'Malka Ganj, Delhi', '+91-11-23968000', 'hindurao@gov.in', 90, 50),

-- Ophthalmologist Hospitals
('Dr. Shroff Charity Eye Hospital', 28.6139, 77.2090, 'Ophthalmologist', 'Kedar Nath Road, Karol Bagh, New Delhi', '+91-11-25739919', 'info@sceh.net', 50, 25),
('Centre for Sight', 28.5355, 77.3910, 'Ophthalmologist', 'Safdarjung Enclave, New Delhi', '+91-11-29251616', 'info@centreforsight.net', 40, 20),
('Sharp Sight Eye Hospitals', 28.4595, 77.0266, 'Ophthalmologist', 'Rajouri Garden, New Delhi', '+91-11-25415566', 'care@sharpsight.in', 45, 22),

-- Pediatrician Hospitals
('Chacha Nehru Bal Chikitsalaya', 28.6507, 77.2334, 'Pediatrician', 'Geeta Colony, Delhi', '+91-11-22235888', 'cnbc@gov.in', 200, 120),
('Kalawati Saran Children Hospital', 28.6358, 77.2244, 'Pediatrician', 'Ansari Nagar, New Delhi', '+91-11-26588663', 'ksch@aiims.edu', 150, 80),
('Rainbow Children Hospital', 28.5245, 77.1855, 'Pediatrician', 'Sector 14, Gurgaon', '+91-124-4200000', 'info@rainbowhospitals.in', 100, 60),

-- Dermatologist Hospitals
('AIIMS Dermatology', 28.5672, 77.2100, 'Dermatologist', 'Ansari Nagar, New Delhi', '+91-11-26594494', 'derma@aiims.edu', 60, 35),
('Skin & Hair Clinic', 28.6304, 77.2177, 'Dermatologist', 'Greater Kailash, New Delhi', '+91-11-29234567', 'info@skinhair.com', 40, 25),
('Dermalife Clinic', 28.5706, 77.2137, 'Dermatologist', 'Lajpat Nagar, New Delhi', '+91-11-29876543', 'care@dermalife.in', 35, 20),

-- Pulmonologist Hospitals
('Chest & TB Hospital', 28.6692, 77.2265, 'Pulmonologist', 'Hindpiri, Delhi', '+91-11-23456789', 'chest@gov.in', 80, 45),
('Lung Care International', 28.4089, 77.0428, 'Pulmonologist', 'Sector 44, Gurgaon', '+91-124-4567890', 'info@lungcare.com', 70, 40),
('Respiratory Care Center', 28.5355, 77.3910, 'Pulmonologist', 'Noida Sector 18', '+91-120-4567891', 'care@respiratory.in', 65, 35);



INSERT INTO doctors (hospital_id, name, speciality, experience_years, availability_status, phone) VALUES
-- Cardiologists
(1, 'Dr. Rajesh Kumar', 'Cardiologist', 15, 'available', '+91-9876543210'),
(1, 'Dr. Priya Sharma', 'Cardiologist', 12, 'available', '+91-9876543211'),
(2, 'Dr. Amit Singh', 'Cardiologist', 18, 'busy', '+91-9876543212'),
(2, 'Dr. Sunita Gupta', 'Cardiologist', 10, 'available', '+91-9876543213'),
(3, 'Dr. Vikram Malhotra', 'Cardiologist', 20, 'available', '+91-9876543214'),

-- Neurologists
(4, 'Dr. Neha Agarwal', 'Neurologist', 14, 'available', '+91-9876543215'),
(4, 'Dr. Rohit Verma', 'Neurologist', 16, 'available', '+91-9876543216'),
(5, 'Dr. Kavita Jain', 'Neurologist', 13, 'busy', '+91-9876543217'),
(5, 'Dr. Suresh Yadav', 'Neurologist', 11, 'available', '+91-9876543218'),
(6, 'Dr. Anita Chopra', 'Neurologist', 17, 'available', '+91-9876543219'),

-- Orthopedists
(7, 'Dr. Manoj Tiwari', 'Orthopedist', 19, 'available', '+91-9876543220'),
(7, 'Dr. Ritu Bhardwaj', 'Orthopedist', 12, 'available', '+91-9876543221'),
(8, 'Dr. Deepak Arora', 'Orthopedist', 15, 'busy', '+91-9876543222'),
(8, 'Dr. Sonia Kapoor', 'Orthopedist', 9, 'available', '+91-9876543223'),
(9, 'Dr. Ashok Mehta', 'Orthopedist', 22, 'available', '+91-9876543224'),

-- Emergency Physicians
(10, 'Dr. Ramesh Chand', 'Emergency Physician', 25, 'available', '+91-9876543225'),
(10, 'Dr. Pooja Nair', 'Emergency Physician', 8, 'available', '+91-9876543226'),
(11, 'Dr. Sanjay Dubey', 'Emergency Physician', 20, 'available', '+91-9876543227'),
(11, 'Dr. Meera Reddy', 'Emergency Physician', 12, 'busy', '+91-9876543228'),
(12, 'Dr. Ajay Pandey', 'Emergency Physician', 18, 'available', '+91-9876543229'),

-- General Surgeons
(13, 'Dr. Vinod Khanna', 'General Surgeon', 24, 'available', '+91-9876543230'),
(13, 'Dr. Shweta Bansal', 'General Surgeon', 14, 'available', '+91-9876543231'),
(14, 'Dr. Harish Goel', 'General Surgeon', 16, 'busy', '+91-9876543232'),
(14, 'Dr. Nisha Ahluwalia', 'General Surgeon', 11, 'available', '+91-9876543233'),
(15, 'Dr. Kiran Bedi', 'General Surgeon', 13, 'available', '+91-9876543234'),

-- Ophthalmologists
(16, 'Dr. Rajiv Mohan', 'Ophthalmologist', 21, 'available', '+91-9876543235'),
(16, 'Dr. Seema Joshi', 'Ophthalmologist', 15, 'available', '+91-9876543236'),
(17, 'Dr. Arun Sethi', 'Ophthalmologist', 18, 'busy', '+91-9876543237'),
(17, 'Dr. Vandana Sood', 'Ophthalmologist', 12, 'available', '+91-9876543238'),
(18, 'Dr. Mukesh Garg', 'Ophthalmologist', 16, 'available', '+91-9876543239'),

-- Pediatricians
(19, 'Dr. Rekha Saxena', 'Pediatrician', 19, 'available', '+91-9876543240'),
(19, 'Dr. Sunil Mittal', 'Pediatrician', 14, 'available', '+91-9876543241'),
(20, 'Dr. Geeta Rani', 'Pediatrician', 17, 'busy', '+91-9876543242'),
(20, 'Dr. Pankaj Goyal', 'Pediatrician', 10, 'available', '+91-9876543243'),
(21, 'Dr. Alka Srivastava', 'Pediatrician', 13, 'available', '+91-9876543244'),

-- Dermatologists
(22, 'Dr. Ravi Khurana', 'Dermatologist', 16, 'available', '+91-9876543245'),
(22, 'Dr. Sapna Malhotra', 'Dermatologist', 11, 'available', '+91-9876543246'),
(23, 'Dr. Yogesh Tandon', 'Dermatologist', 14, 'busy', '+91-9876543247'),
(23, 'Dr. Preeti Aggarwal', 'Dermatologist', 9, 'available', '+91-9876543248'),
(24, 'Dr. Manish Gupta', 'Dermatologist', 12, 'available', '+91-9876543249'),

-- Pulmonologists
(25, 'Dr. Satish Kumar', 'Pulmonologist', 20, 'available', '+91-9876543250'),
(25, 'Dr. Usha Devi', 'Pulmonologist', 15, 'available', '+91-9876543251'),
(26, 'Dr. Bharat Singh', 'Pulmonologist', 18, 'busy', '+91-9876543252'),
(26, 'Dr. Rashmi Jain', 'Pulmonologist', 13, 'available', '+91-9876543253'),
(27, 'Dr. Naresh Choudhary', 'Pulmonologist', 16, 'available', '+91-9876543254');



INSERT INTO bookings (hospital_id, hospital_name, patient_name, patient_phone, emergency_type, speciality_needed, injury_type, booking_time, appointment_time, status, booking_reference) VALUES 
(1, 'Apollo Heart Institute', 'John Doe', '+91-9876543210', 'cardiologist', 'Cardiologist', 'cardiologist', NOW(), DATE_ADD(NOW(), INTERVAL 2 HOUR), 'confirmed', 'EMG20250107001'),
(4, 'AIIMS Neurology Center', 'Jane Smith', '+91-9876543211', 'neurologist', 'Neurologist', 'neurologist', NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY + INTERVAL 2 HOUR, 'completed', 'EMG20250106001'),
(7, 'Indian Spinal Injuries Centre', 'Mike Johnson', '+91-9876543212', 'orthopedist', 'Orthopedist', 'orthopedist', NOW() - INTERVAL 2 HOUR, NOW() + INTERVAL 1 HOUR, 'pending', 'EMG20250107002'),
(10, 'All India Institute of Medical Sciences', 'Sarah Wilson', '+91-9876543213', 'emergency_physician', 'Emergency Physician', 'emergency_physician', NOW() - INTERVAL 30 MINUTE, NOW() + INTERVAL 1 HOUR, 'confirmed', 'EMG20250107003'),
(13, 'Sir Ganga Ram Hospital', 'David Brown', '+91-9876543214', 'general_surgeon', 'General Surgeon', 'general_surgeon', NOW() - INTERVAL 3 HOUR, NOW() + INTERVAL 3 HOUR, 'confirmed', 'EMG20250107004');


CREATE VIEW hospital_availability AS
SELECT 
    h.id,
    h.name,
    h.latitude,
    h.longitude,
    h.speciality,
    h.beds_available,
    h.phone,
    h.address,
    COUNT(d.id) as doctor_count,
    COUNT(CASE WHEN d.availability_status = 'available' THEN 1 END) as available_doctors
FROM hospitals h
LEFT JOIN doctors d ON h.id = d.hospital_id
GROUP BY h.id, h.name, h.latitude, h.longitude, h.speciality, h.beds_available, h.phone, h.address;


DELIMITER //
CREATE PROCEDURE UpdateBedAvailability()
BEGIN
    UPDATE hospitals 
    SET beds_available = GREATEST(0, beds_total - FLOOR(RAND() * (beds_total * 0.7)))
    WHERE beds_available > 0;
END//
DELIMITER ;


SELECT 'Hospitals' as table_name, COUNT(*) as count FROM hospitals
UNION ALL
SELECT 'Doctors' as table_name, COUNT(*) as count FROM doctors
UNION ALL
SELECT 'Bookings' as table_name, COUNT(*) as count FROM bookings;


SELECT speciality, COUNT(*) as hospital_count 
FROM hospitals 
GROUP BY speciality 
ORDER BY hospital_count DESC;


SELECT 'Hospital Database Setup Complete!' as Status,
       'Total Hospitals: 27' as Hospitals,
       'Total Doctors: 54' as Doctors,
       'Total Specialties: 9' as Specialties,
       'Sample Bookings: 5' as Bookings;
