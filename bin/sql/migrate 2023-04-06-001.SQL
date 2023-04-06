DROP DATABASE publication_repo;

CREATE DATABASE publication_repo;

USE publication_repo;

CREATE TABLE faculty (
  faculty_id        VARCHAR (10) NOT NULL,
  faculty_name      VARCHAR (50),
  PRIMARY KEY (faculty_id)
);

CREATE TABLE study_program (
  program_id        INT NOT NULL,
  program_name      VARCHAR (20),
  faculty_id        VARCHAR (10),
  PRIMARY KEY (program_id),
  FOREIGN KEY (faculty_id) REFERENCES faculty (faculty_id)
);

CREATE TABLE app_user (
  user_id           VARCHAR (50) NOT  NULL,
  email             VARCHAR (70),
  full_name         VARCHAR (50),
  password_salt     VARCHAR (16),
  password_pepper   VARCHAR (16),
  password_hash     VARCHAR (256),
  program_id        INT,
  PRIMARY KEY (user_id),
  FOREIGN KEY (program_id) REFERENCES study_program (program_id)
);

CREATE TABLE app_role (
  role_id           INT NOT NULL,
  role_name         VARCHAR (20),
  PRIMARY KEY (role_id)
);

CREATE TABLE app_user_role (
  user_id           VARCHAR (50) NOT NULL,
  role_id           INT NOT NULL,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES app_user (user_id),
  FOREIGN KEY (role_id) REFERENCES app_role (role_id)
);

-- INSERTING INITIAL VALUES FOR faculty
INSERT INTO faculty VALUES 
('FOB', 'Faculty of Business'),
('FET', 'Faculty of Engineering & Technology'),
('FOE', 'Faculty of Education'),
('FAS', 'Faculty of Arts & Science');

-- INSERTING INITIAL VALUES FOR study_program
INSERT INTO study_program VALUES
(1, 'Entrepreneurship', 'FOB'),
(2, 'Banking and Finance', 'FOB'),
(3, 'Digital Marketing', 'FOB'),
(4, 'Accounting', 'FOB'),
(5, 'Mechanical Engineering', 'FET'),
(6, 'Industrial Engineering', 'FET'),
(7, 'Visual Communication Design', 'FET'),
(8, 'Computer Science', 'FET'),
(9, 'Information Systems', 'FET'),
(10, 'English Language Education', 'FOE'),
(11, 'Mathematics Education', 'FOE'),
(12, 'Psychology', 'FAS');

-- INSERTING INITIAL VALUES FOR app_user
INSERT INTO app_user VALUES
('2020390020', 'roger.cashley@my.sampoernauniversity.ac.id', 'Roger Cashley', 'vcJAXKzQKQbf5inx', 'KQhoWmab8akZCD11', '$2y$10$Ab1Ks3ViX4g8c7CqQHLKseNQ2rEvyVLp0I6CqZz2hpJaV3WFkVe8G', 8),
('2020390018', 'mikha.wy@my.sampoernauniversity.ac.id', 'Mikha Kelaya Wy', 'uLUHw1xgMm6IKeWc', 'skKFwYXy33qkeJXv', '$2y$10$m/8T5q/BaswfC9roeuCqqu40uzd247Zdk45eg2UacIRNHguQ0rtIm', 8),
('2019390018', 'madina.chumaera@my.sampoernauniversity.ac.id', 'Madina Malahayati Chumaera', 'c5YXUbRejXpCmZBi', 'nx4OqMiu4QQYagf1', '$2y$10$Bej4E10PTIKt1rVkZTpWwugyn3IqyAM8UdWBGLnpOI7MzUoJCUY8.', 8);

-- INSERTING INITIAL VALUES FOR app_role
INSERT INTO app_role VALUES
(1, 'administrator'),
(2, 'lecturer'),
(3, 'faculty admin'),
(4, 'student');

-- INSERTING INITIAL VALUES FOR app_user_role
INSERT INTO app_user_role VALUES
('2020390020', 4),
('2020390018', 4),
('2019390018', 4);
