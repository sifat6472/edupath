-- EduPath MySQL Schema
-- Run this if using MySQL instead of SQLite fallback

CREATE DATABASE IF NOT EXISTS edupath CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE edupath;

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','admin','professor') NOT NULL DEFAULT 'student',
    phone VARCHAR(50),
    avatar VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS universities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    country VARCHAR(100) NOT NULL,
    city VARCHAR(100),
    ranking INT,
    website VARCHAR(255),
    logo VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_country (country)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS programs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    university_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    degree_level VARCHAR(50) NOT NULL,
    field VARCHAR(100),
    duration VARCHAR(50),
    tuition_fee DECIMAL(10,2),
    location VARCHAR(255),
    application_deadline DATE,
    intake_size INT,
    overview TEXT,
    requirements TEXT,
    scholarship_available TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE,
    INDEX idx_field (field),
    INDEX idx_deadline (application_deadline)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS scholarships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    provider VARCHAR(255) NOT NULL,
    country VARCHAR(100),
    award_amount VARCHAR(100),
    deadline DATE,
    study_level VARCHAR(100),
    scholarship_type VARCHAR(100),
    eligibility TEXT,
    description TEXT,
    benefits TEXT,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_deadline (deadline)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS professors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    university_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    department VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    research_area VARCHAR(255),
    publications INT DEFAULT 0,
    accepting_students TINYINT(1) DEFAULT 1,
    bio TEXT,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE,
    INDEX idx_research (research_area),
    INDEX idx_accepting (accepting_students)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS laboratories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    professor_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    funded TINYINT(1) DEFAULT 1,
    funding_source VARCHAR(255),
    research_focus TEXT,
    open_positions INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES professors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS applications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    program_id BIGINT UNSIGNED,
    scholarship_id BIGINT UNSIGNED,
    professor_id BIGINT UNSIGNED,
    type ENUM('program','scholarship','lab') NOT NULL,
    status ENUM('pending','submitted','reviewing','accepted','rejected') DEFAULT 'pending',
    progress INT DEFAULT 0,
    full_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    current_education VARCHAR(255),
    gpa VARCHAR(20),
    test_score VARCHAR(20),
    work_experience TEXT,
    statement_of_purpose TEXT,
    documents TEXT,
    submitted_at TIMESTAMP NULL,
    deadline DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_type (type)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT,
    type VARCHAR(50) DEFAULT 'info',
    is_read TINYINT(1) DEFAULT 0,
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_read (user_id, is_read)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS saved_programs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    item_type ENUM('program','scholarship','professor') NOT NULL,
    item_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY uk_user_item (user_id, item_type, item_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user_preferences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    preferred_country VARCHAR(100),
    preferred_field VARCHAR(100),
    preferred_degree VARCHAR(50),
    budget_range VARCHAR(50),
    interests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
