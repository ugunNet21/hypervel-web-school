-- Select the database
USE db_web_school;

-- 1. Core Tables

-- Users table (central authentication, modified for Spatie compatibility)
CREATE TABLE users (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    avatar_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Roles table (Spatie version with UUID)
CREATE TABLE roles (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_name_guard (name, guard_name)
);

-- Permissions table (Spatie version with UUID)
CREATE TABLE permissions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_name_guard (name, guard_name)
);

-- Model Has Roles table (Spatie version)
CREATE TABLE model_has_roles (
    role_id CHAR(36) NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id CHAR(36) NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    INDEX idx_model_has_roles_model (model_type, model_id)
);

-- Model Has Permissions table (Spatie version)
CREATE TABLE model_has_permissions (
    permission_id CHAR(36) NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id CHAR(36) NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    INDEX idx_model_has_permissions_model (model_type, model_id)
);

-- Role Has Permissions table (Spatie version)
CREATE TABLE role_has_permissions (
    permission_id CHAR(36) NOT NULL,
    role_id CHAR(36) NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- 2. School Management Tables

-- Parents table (created before students to satisfy foreign key)
CREATE TABLE parents (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) UNIQUE NOT NULL,
    occupation VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Teachers table (created before classes to satisfy foreign key)
CREATE TABLE teachers (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) UNIQUE NOT NULL,
    nip VARCHAR(20) UNIQUE NOT NULL,
    expertise VARCHAR(100),
    join_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Classes table
CREATE TABLE classes (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(50) NOT NULL,
    level VARCHAR(20) NOT NULL,
    homeroom_teacher_id CHAR(36),
    academic_year VARCHAR(9) NOT NULL,
    capacity INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (homeroom_teacher_id) REFERENCES teachers(id)
);

-- Students table
CREATE TABLE students (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) UNIQUE NOT NULL,
    nisn VARCHAR(20) UNIQUE NOT NULL,
    class_id CHAR(36),
    birth_date DATE,
    birth_place VARCHAR(50),
    address TEXT,
    parent_id CHAR(36),
    enrollment_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (parent_id) REFERENCES parents(id)
);

-- Staff table
CREATE TABLE staff (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) UNIQUE NOT NULL,
    position VARCHAR(100) NOT NULL,
    department VARCHAR(100),
    join_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Subjects table
CREATE TABLE subjects (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    code VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    credit_hours INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Class-Subject relationship
CREATE TABLE class_subjects (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    class_id CHAR(36) NOT NULL,
    subject_id CHAR(36) NOT NULL,
    teacher_id CHAR(36),
    schedule_info TEXT,
    UNIQUE (class_id, subject_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

-- Schedules table
CREATE TABLE schedules (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    class_subject_id CHAR(36) NOT NULL,
    day_of_week SMALLINT NOT NULL, -- Note: CHECK constraint not supported in MySQL < 8.0.16; enforce in application
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_subject_id) REFERENCES class_subjects(id) ON DELETE CASCADE
);

-- School Inventory table (fixed with backtick for 'condition')
CREATE TABLE school_inventory (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    quantity INTEGER NOT NULL,
    location VARCHAR(100),
    `condition` VARCHAR(50),
    purchase_date DATE,
    last_maintenance DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. PPDB (New Student Admission) Tables

-- PPDB Registrations
CREATE TABLE ppdb_registrations (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    registration_number VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    birth_place VARCHAR(50) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    parent_name VARCHAR(100) NOT NULL,
    parent_phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    previous_school VARCHAR(100),
    intended_class VARCHAR(50) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PPDB Documents
CREATE TABLE ppdb_documents (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    registration_id CHAR(36) NOT NULL,
    document_type VARCHAR(50) NOT NULL,
    file_url VARCHAR(255) NOT NULL,
    verification_status VARCHAR(20) DEFAULT 'pending',
    verified_by CHAR(36),
    verified_at TIMESTAMP,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES ppdb_registrations(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id)
);

-- PPDB Tests
CREATE TABLE ppdb_tests (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    registration_id CHAR(36) NOT NULL,
    test_type VARCHAR(50) NOT NULL,
    score DECIMAL(5,2),
    test_date TIMESTAMP,
    administrator_id CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES ppdb_registrations(id) ON DELETE CASCADE,
    FOREIGN KEY (administrator_id) REFERENCES users(id)
);

-- PPDB Announcements
CREATE TABLE ppdb_announcements (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    registration_id CHAR(36) NOT NULL,
    announcement_type VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    published_by CHAR(36),
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES ppdb_registrations(id) ON DELETE CASCADE,
    FOREIGN KEY (published_by) REFERENCES users(id)
);

-- 4. E-Learning Tables

-- Virtual Classes
CREATE TABLE virtual_classes (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    class_id CHAR(36),
    subject_id CHAR(36),
    teacher_id CHAR(36),
    name VARCHAR(100) NOT NULL,
    description TEXT,
    code VARCHAR(10) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

-- Learning Materials
CREATE TABLE learning_materials (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    virtual_class_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    file_url VARCHAR(255),
    material_type VARCHAR(50) NOT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    publish_date TIMESTAMP,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (virtual_class_id) REFERENCES virtual_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Assignments
CREATE TABLE assignments (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    virtual_class_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    due_date TIMESTAMP NOT NULL,
    max_score INTEGER,
    is_published BOOLEAN DEFAULT FALSE,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (virtual_class_id) REFERENCES virtual_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Quizzes
CREATE TABLE quizzes (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    virtual_class_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    time_limit_minutes INTEGER,
    max_attempts INTEGER DEFAULT 1,
    is_published BOOLEAN DEFAULT FALSE,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (virtual_class_id) REFERENCES virtual_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Discussions
CREATE TABLE discussions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    virtual_class_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (virtual_class_id) REFERENCES virtual_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Discussion Replies
CREATE TABLE discussion_replies (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    discussion_id CHAR(36) NOT NULL,
    content TEXT NOT NULL,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (discussion_id) REFERENCES discussions(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Video Conferences
CREATE TABLE video_conferences (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    virtual_class_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    meeting_id VARCHAR(100) NOT NULL,
    meeting_password VARCHAR(50),
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (virtual_class_id) REFERENCES virtual_classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- 5. Grading and Reporting Tables

-- Grades
CREATE TABLE grades (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    subject_id CHAR(36) NOT NULL,
    class_id CHAR(36) NOT NULL,
    grade DECIMAL(5,2) NOT NULL,
    semester SMALLINT NOT NULL,
    grade_type VARCHAR(50) NOT NULL,
    assignment_id CHAR(36),
    quiz_id CHAR(36),
    exam_id CHAR(36),
    notes TEXT,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (assignment_id) REFERENCES assignments(id),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
    -- Note: exam_id foreign key is added later after exams table creation
);

-- Competencies
CREATE TABLE competencies (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    subject_id CHAR(36) NOT NULL,
    competency_code VARCHAR(20) NOT NULL,
    competency_name VARCHAR(100) NOT NULL,
    achievement_level VARCHAR(50) NOT NULL,
    semester SMALLINT NOT NULL,
    notes TEXT,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Reports
CREATE TABLE reports (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    class_id CHAR(36) NOT NULL,
    semester SMALLINT NOT NULL,
    academic_year VARCHAR(9) NOT NULL,
    average_grade DECIMAL(5,2),
    rank_in_class INTEGER,
    homeroom_notes TEXT,
    principal_notes TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Student Portfolios
CREATE TABLE student_portfolios (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    file_url VARCHAR(255),
    portfolio_type VARCHAR(50) NOT NULL,
    date_added DATE NOT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- 6. Online Exam Tables

-- Question Bank
CREATE TABLE question_bank (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    subject_id CHAR(36) NOT NULL,
    question_type VARCHAR(50) NOT NULL,
    difficulty_level VARCHAR(20),
    question_text TEXT NOT NULL,
    options JSON,
    correct_answer TEXT NOT NULL,
    explanation TEXT,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Exams
CREATE TABLE exams (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(100) NOT NULL,
    exam_type VARCHAR(20) NOT NULL,
    subject_id CHAR(36),
    class_id CHAR(36),
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    duration_minutes INTEGER NOT NULL,
    passing_grade DECIMAL(5,2),
    is_published BOOLEAN DEFAULT FALSE,
    proctoring_enabled BOOLEAN DEFAULT FALSE,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Add missing foreign key to grades table for exam_id
ALTER TABLE grades
ADD CONSTRAINT fk_grades_exam_id
FOREIGN KEY (exam_id) REFERENCES exams(id);

-- Exam Questions
CREATE TABLE exam_questions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    exam_id CHAR(36) NOT NULL,
    question_id CHAR(36) NOT NULL,
    points DECIMAL(5,2) NOT NULL,
    question_order INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES question_bank(id) ON DELETE CASCADE
);

-- Exam Results
CREATE TABLE exam_results (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    exam_id CHAR(36) NOT NULL,
    student_id CHAR(36) NOT NULL,
    start_time TIMESTAMP,
    end_time TIMESTAMP,
    total_score DECIMAL(5,2),
    passing_status VARCHAR(20),
    proctoring_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Exam Answers
CREATE TABLE exam_answers (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    exam_result_id CHAR(36) NOT NULL,
    question_id CHAR(36) NOT NULL,
    answer TEXT,
    is_correct BOOLEAN,
    score DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_result_id) REFERENCES exam_results(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES question_bank(id) ON DELETE CASCADE
);

-- 7. Digital Library Tables

-- Books
CREATE TABLE books (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    isbn VARCHAR(20),
    title VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    publisher VARCHAR(100),
    publication_year INTEGER,
    category VARCHAR(50) NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    available_quantity INTEGER NOT NULL DEFAULT 1,
    cover_url VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ebook Formats
CREATE TABLE ebook_formats (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    book_id CHAR(36) NOT NULL,
    format VARCHAR(10) NOT NULL,
    file_url VARCHAR(255) NOT NULL,
    file_size BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Book Loans
CREATE TABLE book_loans (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    book_id CHAR(36) NOT NULL,
    borrower_id CHAR(36) NOT NULL,
    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    status VARCHAR(20) DEFAULT 'borrowed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (borrower_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Book Reviews
CREATE TABLE book_reviews (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    book_id CHAR(36) NOT NULL,
    reviewer_id CHAR(36) NOT NULL,
    rating SMALLINT NOT NULL, -- CHECK (rating BETWEEN 1 AND 5) not supported; enforce in application
    review_text TEXT,
    is_public BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 8. Premium Features Tables

-- AI Tutor Sessions
CREATE TABLE ai_tutor_sessions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    subject_id CHAR(36),
    session_topic VARCHAR(200) NOT NULL,
    conversation_history JSON,
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Career Assessments
CREATE TABLE career_assessments (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    assessment_type VARCHAR(50) NOT NULL,
    assessment_date DATE NOT NULL,
    results JSON,
    recommendations TEXT,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Counseling Sessions
CREATE TABLE counseling_sessions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    student_id CHAR(36) NOT NULL,
    counselor_id CHAR(36) NOT NULL,
    session_date DATE NOT NULL,
    session_time TIME NOT NULL,
    duration_minutes INTEGER NOT NULL,
    notes TEXT,
    follow_up_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (counselor_id) REFERENCES teachers(id) ON DELETE CASCADE
);

-- Industry Partners
CREATE TABLE industry_partners (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(100) NOT NULL,
    industry VARCHAR(50) NOT NULL,
    contact_person VARCHAR(100),
    contact_email VARCHAR(100),
    contact_phone VARCHAR(20),
    partnership_details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. Monetization Tables

-- Marketplace Products
CREATE TABLE marketplace_products (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    stock_quantity INTEGER NOT NULL,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_by CHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Transactions
CREATE TABLE transactions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    transaction_type VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL,
    reference_id VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Transaction Items
CREATE TABLE transaction_items (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    transaction_id CHAR(36) NOT NULL,
    product_id CHAR(36),
    item_type VARCHAR(50) NOT NULL,
    description VARCHAR(200) NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES marketplace_products(id)
);

-- 10. System Tables

-- Audit Logs
CREATE TABLE audit_logs (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36),
    action VARCHAR(50) NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id CHAR(36),
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- System Settings
CREATE TABLE system_settings (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index Creation for Performance

-- Core tables indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_roles_guard_name ON roles(guard_name);
CREATE INDEX idx_permissions_guard_name ON permissions(guard_name);
CREATE INDEX idx_role_has_permissions_role_id ON role_has_permissions(role_id);

-- Student-related indexes
CREATE INDEX idx_students_user_id ON students(user_id);
CREATE INDEX idx_students_class_id ON students(class_id);
CREATE INDEX idx_students_parent_id ON students(parent_id);
CREATE INDEX idx_students_nisn ON students(nisn);

-- Teacher-related indexes
CREATE INDEX idx_teachers_user_id ON teachers(user_id);
CREATE INDEX idx_teachers_nip ON teachers(nip);

-- Class and subject indexes
CREATE INDEX idx_class_subjects_class_id ON class_subjects(class_id);
CREATE INDEX idx_class_subjects_subject_id ON class_subjects(subject_id);
CREATE INDEX idx_class_subjects_teacher_id ON class_subjects(teacher_id);

-- E-learning indexes
CREATE INDEX idx_virtual_classes_class_id ON virtual_classes(class_id);
CREATE INDEX idx_virtual_classes_subject_id ON virtual_classes(subject_id);
CREATE INDEX idx_learning_materials_virtual_class_id ON learning_materials(virtual_class_id);
CREATE INDEX idx_assignments_virtual_class_id ON assignments(virtual_class_id);

-- Exam indexes
CREATE INDEX idx_exam_questions_exam_id ON exam_questions(exam_id);
CREATE INDEX idx_exam_results_exam_id ON exam_results(exam_id);
CREATE INDEX idx_exam_results_student_id ON exam_results(student_id);
CREATE INDEX idx_exam_answers_exam_result_id ON exam_answers(exam_result_id);

-- Library indexes
CREATE INDEX idx_book_loans_book_id ON book_loans(book_id);
CREATE INDEX idx_book_loans_borrower_id ON book_loans(borrower_id);
CREATE INDEX idx_book_reviews_book_id ON book_reviews(book_id);

-- Inventory index (tambahan untuk school_inventory)
CREATE INDEX idx_school_inventory_category ON school_inventory(category);