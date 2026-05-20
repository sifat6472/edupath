<?php
/**
 * Database Seeder
 * Realistic dummy data for EduPath
 */

$pdo = \App\Core\Database::getInstance()->pdo();

// === USERS ===
$users = [
    ['Nafis Islam', 'nafis@edupath.com', password_hash('password', PASSWORD_DEFAULT), 'student', '+8801712345678'],
    ['Admin User', 'admin@edupath.com', password_hash('admin123', PASSWORD_DEFAULT), 'admin', '+8801987654321'],
    ['Dr. Sarah Ahmed', 'sarah.ahmed@mit.edu', password_hash('professor', PASSWORD_DEFAULT), 'professor', '+1617000001'],
];
$stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
foreach ($users as $u) $stmt->execute($u);

// === UNIVERSITIES ===
$universities = [
    ['Massachusetts Institute of Technology', 'USA', 'Cambridge, MA', 1, 'mit.edu', 'World-leading research university in science and engineering.'],
    ['Stanford University', 'USA', 'Stanford, CA', 2, 'stanford.edu', 'Premier private research university known for innovation.'],
    ['University of Cambridge', 'UK', 'Cambridge', 3, 'cam.ac.uk', 'Historic university with world-class academic reputation.'],
    ['University of Oxford', 'UK', 'Oxford', 4, 'ox.ac.uk', 'Oldest university in the English-speaking world.'],
    ['Harvard University', 'USA', 'Cambridge, MA', 5, 'harvard.edu', 'Ivy League institution recognized globally.'],
    ['ETH Zurich', 'Switzerland', 'Zurich', 6, 'ethz.ch', 'Leading technical and natural sciences university in Europe.'],
    ['National University of Singapore', 'Singapore', 'Singapore', 7, 'nus.edu.sg', 'Top university in Asia for research and education.'],
    ['University of Toronto', 'Canada', 'Toronto', 8, 'utoronto.ca', 'Premier Canadian research-intensive university.'],
];
$stmt = $pdo->prepare("INSERT INTO universities (name, country, city, ranking, website, description) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($universities as $u) $stmt->execute($u);

// === PROGRAMS ===
$programs = [
    [1, 'MSc Computer Science', 'Masters', 'Computer Science', '2 years', 55000, 'Cambridge, MA, USA', '2026-04-15', 60, 
     "MIT's master's program advances scholarly study in fields like science, engineering, management, and architecture, combining rigorous coursework with research-led hands-on projects. They emphasize innovation, problem-solving, and real-world impact, preparing students for leadership roles in industry and academia.",
     "Bachelor's degree from a recognized institution; Strong academic background; Statement of purpose; Proof of English proficiency for international students", 1],
    [1, 'MSc Bio Informatics', 'Masters', 'Bio Informatics', '2 years', 56000, 'Cambridge, MA, USA', '2026-05-20', 40,
     "Interdisciplinary program blending biology, computer science, and data analytics to drive discoveries in genomics and health sciences.",
     "Bachelor's degree in life sciences, computer science, or related; GRE recommended; Statement of purpose", 1],
    [1, 'MSc Software Engineering', 'Masters', 'Software Engineering', '1 year', 55000, 'Cambridge, MA, USA', '2026-06-10', 50,
     "Hands-on engineering program focusing on building production-grade software systems at scale.",
     "Bachelor's in CS or related; Programming portfolio; Strong English proficiency", 1],
    [2, 'MSc Artificial Intelligence', 'Masters', 'Artificial Intelligence', '2 years', 58000, 'Stanford, CA, USA', '2026-04-30', 45,
     "Stanford's AI program is at the cutting edge of machine learning, deep learning, and robotics research.",
     "Strong math and CS background; Research experience preferred; GRE optional", 1],
    [3, 'MPhil Computer Science', 'Masters', 'Computer Science', '1 year', 38000, 'Cambridge, UK', '2026-05-01', 30,
     "Research-focused MPhil at the historic University of Cambridge with access to leading labs.",
     "First-class undergraduate degree; Research proposal; English proficiency (IELTS 7.5+)", 0],
    [6, 'MSc Data Science', 'Masters', 'Data Science', '2 years', 1500, 'Zurich, Switzerland', '2026-03-15', 35,
     "ETH's Data Science program combines statistics, machine learning, and large-scale computation.",
     "Bachelor's in CS, Math, or Engineering; Strong analytical background", 1],
];
$stmt = $pdo->prepare("INSERT INTO programs (university_id, title, degree_level, field, duration, tuition_fee, location, application_deadline, intake_size, overview, requirements, scholarship_available) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($programs as $p) $stmt->execute($p);

// === SCHOLARSHIPS ===
$scholarships = [
    ['Fulbright Foreign Student Program', 'U.S. Department of State', 'United States', 'Full Tuition + Living Expenses', '2026-02-15', 'Graduate', 'Merit Based',
     "Open to international students worldwide with strong academic background and English proficiency.",
     "The Fulbright Scholarship is a prestigious international program funded by the U.S. government that supports students, researchers, and professionals to study, teach, or conduct research abroad.",
     "Financial Support, Academic Excellence, Global Network",
     "Bachelor's degree or equivalent; Strong academic background; English language proficiency; Statement of purpose or study objectives; Letters of recommendation"],
    ['Chevening Scholarship', 'UK Government', 'United Kingdom', 'Full Tuition + Stipend', '2026-11-02', 'Masters', 'Government',
     "Open to citizens of Chevening-eligible countries with leadership potential.",
     "Chevening is the UK government's international scholarships programme funded by the Foreign, Commonwealth & Development Office.",
     "Full tuition, Monthly stipend, Travel costs, Networking opportunities",
     "Undergraduate degree; 2 years work experience; Apply to 3 UK universities; English language proficiency"],
    ['DAAD Scholarship', 'German Academic Exchange Service', 'Germany', '€934/month + Tuition', '2026-10-31', 'Graduate', 'Merit Based',
     "International students seeking masters or doctoral studies in Germany.",
     "DAAD scholarships support international students pursuing graduate studies at German universities.",
     "Monthly stipend, Travel allowance, Health insurance, Tuition coverage",
     "Bachelor's degree; German or English proficiency; Research proposal for PhD"],
    ['Rhodes Scholarship', 'Rhodes Trust', 'United Kingdom', 'Full Tuition + Stipend', '2026-09-30', 'Graduate', 'Merit Based',
     "Outstanding students worldwide for postgraduate study at Oxford.",
     "The Rhodes Scholarship is the oldest and most celebrated international fellowship award.",
     "Full Oxford tuition, Annual stipend, Travel costs, Networking",
     "Strong academic record; Leadership qualities; Age 18-28; Bachelor's degree"],
    ['Knight-Hennessy Scholars', 'Stanford University', 'United States', 'Full Funding', '2026-10-12', 'Graduate', 'Merit Based',
     "Global leaders pursuing graduate studies at Stanford.",
     "Knight-Hennessy provides full funding for up to three years of graduate study at Stanford.",
     "Full tuition, Stipend, Travel grants, Leadership programming",
     "Bachelor's degree within last 7 years; Apply to Stanford grad program"],
];
$stmt = $pdo->prepare("INSERT INTO scholarships (name, provider, country, award_amount, deadline, study_level, scholarship_type, eligibility, description, benefits, requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($scholarships as $s) $stmt->execute($s);

// === PROFESSORS ===
$professors = [
    [3, 1, 'Dr. Sarah Ahmed', 'Professor of Computer Science', 'EECS', 'sarah.ahmed@mit.edu', 'Machine Learning, AI ethics', 156, 1, 'Leading researcher in machine learning fairness and AI ethics with 15+ years of experience.'],
    [null, 1, 'Dr. James Chen', 'Associate Professor', 'EECS', 'jchen@mit.edu', 'Computer Vision, Deep Learning', 98, 1, 'Working on cutting-edge computer vision applications.'],
    [null, 1, 'Dr. Maria Rodriguez', 'Professor', 'EECS', 'mrodriguez@mit.edu', 'Robotics, Autonomous Systems', 142, 0, 'Researcher in autonomous robotics and human-robot interaction.'],
    [null, 2, 'Dr. Robert Kim', 'Professor of Computer Science', 'CS Department', 'rkim@stanford.edu', 'Natural Language Processing', 187, 1, 'NLP and large language model researcher.'],
    [null, 2, 'Dr. Emily Watson', 'Assistant Professor', 'CS Department', 'ewatson@stanford.edu', 'Reinforcement Learning', 67, 1, 'RL applications in real-world systems.'],
    [null, 3, 'Dr. Alan Turing II', 'Professor', 'Computer Lab', 'aturing@cam.ac.uk', 'Theoretical CS, Quantum Computing', 211, 1, 'Quantum computing pioneer at Cambridge.'],
];
$stmt = $pdo->prepare("INSERT INTO professors (user_id, university_id, name, title, department, email, research_area, publications, accepting_students, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($professors as $p) $stmt->execute($p);

// === LABORATORIES ===
$labs = [
    [1, 'MIT AI Lab', 'Research lab focused on AI ethics, fairness in ML, and explainable AI.', 1, 'NSF, DARPA', 'AI Ethics, Fair ML, Explainability', 3],
    [2, 'Vision Lab', 'Cutting-edge computer vision research.', 1, 'Google Research', 'CV, Deep Learning, Image Generation', 2],
    [3, 'Robotics Group', 'Autonomous systems and HRI research.', 1, 'NASA, DoD', 'Autonomous Robots, HRI', 0],
    [4, 'Stanford NLP Group', 'Leading NLP research worldwide.', 1, 'OpenAI, Anthropic', 'LLMs, Language Understanding', 4],
    [5, 'RL Systems Lab', 'Real-world reinforcement learning applications.', 1, 'NSF', 'RL, Robotics', 2],
    [6, 'Quantum Computing Lab', 'Quantum algorithms and hardware.', 1, 'EPSRC, IBM Quantum', 'Quantum Computing', 1],
];
$stmt = $pdo->prepare("INSERT INTO laboratories (professor_id, name, description, funded, funding_source, research_focus, open_positions) VALUES (?, ?, ?, ?, ?, ?, ?)");
foreach ($labs as $l) $stmt->execute($l);

// === SAMPLE APPLICATIONS FOR USER 1 (Nafis) ===
$applications = [
    [1, 1, null, null, 'program', 'submitted', 75, 'Nafis Islam', 'nafis@edupath.com', '+8801712345678', 'BSc Computer Science, University XYZ', '3.8', '320', '2 years Software Engineer at companyX', 'I am passionate about machine learning research...', null, date('Y-m-d H:i:s'), '2026-03-15'],
    [1, 2, null, null, 'program', 'reviewing', 60, 'Nafis Islam', 'nafis@edupath.com', '+8801712345678', 'BSc Computer Science', '3.8', '315', null, null, null, date('Y-m-d H:i:s'), '2026-07-04'],
    [1, 5, null, null, 'program', 'pending', 40, 'Nafis Islam', 'nafis@edupath.com', '+8801712345678', 'BSc Computer Science', '3.8', null, null, null, null, null, '2026-07-18'],
];
$stmt = $pdo->prepare("INSERT INTO applications (user_id, program_id, scholarship_id, professor_id, type, status, progress, full_name, email, phone, current_education, gpa, test_score, work_experience, statement_of_purpose, documents, submitted_at, deadline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($applications as $a) $stmt->execute($a);

// === NOTIFICATIONS ===
$notifications = [
    [1, 'MIT - Submit References', 'Your reference letters are due in 3 days', 'urgent', 0, '/applications'],
    [1, 'Cambridge - Interview Scheduled', 'Your interview is on 14/05/26', 'info', 0, '/applications'],
    [1, 'New Scholarship Match', 'Fulbright matches your profile', 'success', 0, '/scholarships'],
    [1, 'Stanford application progress: 60%', 'Keep going!', 'info', 1, '/applications'],
    [1, 'Welcome to EduPath!', 'Complete your profile to get personalized recommendations.', 'success', 1, '/profile'],
    [1, 'Application Reminder', 'MIT MSc CS application deadline approaching.', 'urgent', 0, '/programs/1'],
];
$stmt = $pdo->prepare("INSERT INTO notifications (user_id, title, message, type, is_read, link) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($notifications as $n) $stmt->execute($n);

// === USER PREFERENCES ===
$stmt = $pdo->prepare("INSERT INTO user_preferences (user_id, preferred_country, preferred_field, preferred_degree, budget_range, interests) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([1, 'USA', 'Computer Science', 'Masters', '$50000-$60000', 'Machine Learning, AI Research']);

// === SAVED PROGRAMS ===
$stmt = $pdo->prepare("INSERT INTO saved_programs (user_id, item_type, item_id) VALUES (?, ?, ?)");
$stmt->execute([1, 'program', 4]);
$stmt->execute([1, 'scholarship', 1]);
$stmt->execute([1, 'professor', 1]);
