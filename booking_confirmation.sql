
DROP TABLE IF EXISTS bookings;



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


CREATE INDEX idx_bookings_hospital_id ON bookings(hospital_id);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_bookings_date ON bookings(booking_date);
CREATE INDEX idx_bookings_reference ON bookings(booking_reference);
