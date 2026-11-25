-- Quiz 3: carreras (seed), cursos y matrículas.
-- Base de datos propia del quiz: quiz3 (no toca la base isw613 de los talleres).
-- Alternativa: usar las migraciones de CodeIgniter (php spark migrate && php spark db:seed QuizSeeder).

CREATE DATABASE IF NOT EXISTS quiz3 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quiz3;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS careers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_careers_name (name)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seed de carreras
INSERT IGNORE INTO careers (name) VALUES
    ('Ingeniería en Sistemas'),
    ('Administración de Empresas'),
    ('Contaduría Pública'),
    ('Derecho'),
    ('Psicología'),
    ('Ingeniería Industrial');

CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    career_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_courses_code (code),
    KEY idx_courses_career (career_id),
    CONSTRAINT fk_courses_career
        FOREIGN KEY (career_id) REFERENCES careers (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seed de cursos (los que aparecen en el formulario de matrícula)
INSERT IGNORE INTO courses (name, code, credits, career_id) VALUES
    ('Programación I', 'ISW-101', 4, 1),
    ('Bases de Datos', 'ISW-210', 4, 1),
    ('Programación en Ambiente Web I', 'ISW-613', 4, 1),
    ('Contabilidad General', 'ADM-110', 3, 2),
    ('Contabilidad de Costos', 'CON-201', 3, 3),
    ('Introducción al Derecho', 'DER-101', 3, 4),
    ('Psicología General', 'PSI-101', 3, 5),
    ('Ingeniería de Métodos', 'IIN-301', 4, 6);

CREATE TABLE IF NOT EXISTS enrollments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    student_document VARCHAR(20) NOT NULL,
    student_email VARCHAR(100) NOT NULL,
    course_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    -- Un estudiante no puede matricularse dos veces en el mismo curso
    UNIQUE KEY uq_enrollments_student_course (student_document, course_id),
    KEY idx_enrollments_course (course_id),
    CONSTRAINT fk_enrollments_course
        FOREIGN KEY (course_id) REFERENCES courses (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
