CREATE DATABASE publication_repo;

USE publication_repo;

CREATE TABLE app_user (
  email             VARCHAR (70),
  full_name         VARCHAR (50),
  password_salt     VARCHAR (16),
  password_pepper   VARCHAR (16),
  password_hash     VARCHAR (256),
  PRIMARY KEY (email)
);

CREATE TABLE app_role (
  role_id           INT,
  role_name         VARCHAR (20),
  PRIMARY KEY (role_id)
);

CREATE TABLE app_user_role (
  email             VARCHAR (70),
  role_id           INT,
  PRIMARY KEY (email),
  FOREIGN KEY (email) REFERENCES app_user (email),
  FOREIGN KEY (role_id) REFERENCES app_role (role_id)
);

CREATE TABLE app_module (
  module_id       INT,
  module_name     VARCHAR (50),
  module_link     VARCHAR (50),
  PRIMARY KEY (module_name, role_id)
);

CREATE TABLE app_role_module (
  role_id   INT,
  module_id INT,
  PRIMARY KEY (role_id, module_id),
  FOREIGN KEY (role_id) REFERENCES app_role (role_id),
  FOREIGN KEY (module_id) REFERENCES app_module (module_id)
);

CREATE TABLE publication (
  publication_id              VARCHAR (20),
  publication_name            VARCHAR (50),
  publication_description     TEXT,
  publication_date            DATETIME,
  PRIMARY KEY (publication_id)
);

CREATE TABLE publication_content (
  publication_id              VARCHAR (20),
  content                     LONGTEXT,
  PRIMARY KEY (publication_id),
  FOREIGN KEY (publication_id) REFERENCES publication (publication_id)
);

CREATE TABLE publication_authors (
  publication_id              VARCHAR (20),
  email                       VARCHAR (70),
  PRIMARY KEY (publication_id, email),
  FOREIGN KEY (publication_id) REFERENCES publication (publication_id),
  FOREIGN KEY (email) REFERENCES app_user (email)
);
