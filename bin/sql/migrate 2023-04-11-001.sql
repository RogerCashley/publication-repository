USE publication_repo;

-- INSERTING MORE VALUES FOR app_user
INSERT INTO app_user VALUES
('CS01', 'media.ayu@sampoernauniversity.ac.id', 'Media Anugerah Ayu', '', '', '', 2);

INSERT INTO app_user (user_id, email, full_name, password_salt, password_pepper, password_hash)
VALUES ('FET01', 'maulidina.l@sampoernauniversity.ac.id', 'Maulidina Lubis', '', '', ''),
('ADMIN01', 'it.services@sampoernauniversity.ac.id', 'IT Services', '', '', '');

-- INSERTING MORE VALUES FOR app_user_role
INSERT INTO app_user_role VALUES
('CS01', 2),
('FET01', 3),
('ADMIN01', 1);