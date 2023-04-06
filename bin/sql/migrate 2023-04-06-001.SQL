DROP DATABASE publication_repo;

CREATE DATABASE publication_repo;

USE publication_repo;

CREATE TABLE study_program (
  program_id        INT NOT NULL,
  program_name      VARCHAR (20),
  PRIMARY KEY (program_id)
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
  role_level        INT,
  PRIMARY KEY (role_id)
);

CREATE TABLE app_user_role (
  user_id           VARCHAR (50) NOT NULL,
  role_id           INT NOT NULL,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES app_user (user_id),
  FOREIGN KEY (role_id) REFERENCES app_role (role_id)
);

CREATE TABLE app_module (
  module_id         INT NOT NULL,
  module_name       VARCHAR (50),
  module_link       VARCHAR (50),
  PRIMARY KEY (module_id)
);

CREATE TABLE app_role_module (
  role_id           INT NOT NULL,
  module_id         INT NOT NULL,
  PRIMARY KEY (role_id, module_id),
  FOREIGN KEY (role_id) REFERENCES app_role (role_id),
  FOREIGN KEY (module_id) REFERENCES app_module (module_id)
);
