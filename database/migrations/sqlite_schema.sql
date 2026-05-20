-- EduPath SQLite Schema
-- (Compatible structure for MySQL with minor adjustments)

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'student' CHECK(role IN ('student','admin','professor')),
    phone TEXT,
    avatar TEXT,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS universities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    country TEXT NOT NULL,
    city TEXT,
    ranking INTEGER,
    website TEXT,
    logo TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS programs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    university_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    degree_level TEXT NOT NULL,
    field TEXT,
    duration TEXT,
    tuition_fee REAL,
    location TEXT,
    application_deadline DATE,
    intake_size INTEGER,
    overview TEXT,
    requirements TEXT,
    scholarship_available INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS scholarships (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    provider TEXT NOT NULL,
    country TEXT,
    award_amount TEXT,
    deadline DATE,
    study_level TEXT,
    scholarship_type TEXT,
    eligibility TEXT,
    description TEXT,
    benefits TEXT,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS professors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    university_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    title TEXT,
    department TEXT,
    email TEXT NOT NULL,
    research_area TEXT,
    publications INTEGER DEFAULT 0,
    accepting_students INTEGER DEFAULT 1,
    bio TEXT,
    photo TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS laboratories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    professor_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    funded INTEGER DEFAULT 1,
    funding_source TEXT,
    research_focus TEXT,
    open_positions INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES professors(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS applications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    program_id INTEGER,
    scholarship_id INTEGER,
    professor_id INTEGER,
    type TEXT NOT NULL CHECK(type IN ('program','scholarship','lab')),
    status TEXT DEFAULT 'pending' CHECK(status IN ('pending','submitted','reviewing','accepted','rejected')),
    progress INTEGER DEFAULT 0,
    full_name TEXT,
    email TEXT,
    phone TEXT,
    current_education TEXT,
    gpa TEXT,
    test_score TEXT,
    work_experience TEXT,
    statement_of_purpose TEXT,
    documents TEXT,
    submitted_at TIMESTAMP,
    deadline DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notifications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    message TEXT,
    type TEXT DEFAULT 'info',
    is_read INTEGER DEFAULT 0,
    link TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS saved_programs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    program_id INTEGER,
    scholarship_id INTEGER,
    item_type TEXT NOT NULL CHECK(item_type IN ('program','scholarship','professor')),
    item_id INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_preferences (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER UNIQUE NOT NULL,
    preferred_country TEXT,
    preferred_field TEXT,
    preferred_degree TEXT,
    budget_range TEXT,
    interests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
