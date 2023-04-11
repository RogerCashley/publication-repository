USE publication_repo;

-- INSERTING MORE VALUES FOR app_user
INSERT INTO app_user VALUES
('CS01', 'media.ayu@sampoernauniversity.ac.id', 'Media Anugerah Ayu', '', '', '', 2);

INSERT INTO app_user (user_id, email, full_name, password_salt, password_pepper, password_hash)
VALUES 
('FET01', 'maulidina.l@sampoernauniversity.ac.id', 'Maulidina Lubis', '', '', ''),
('ADMIN01', 'it.services@sampoernauniversity.ac.id', 'IT Services', '', '', '');

-- INSERTING MORE VALUES FOR app_user_role
INSERT INTO app_user_role VALUES
('CS01', 2),
('FET01', 3),
('ADMIN01', 1);

UPDATE app_user SET password_salt = 'TWsDgjgerOzCHFWL', password_pepper = 'evbcwXgsROa4cgGj', password_hash = '$2y$10$nGU7L0FF/ogVWzQpa9d3rObERF0AlN9cuh7jda0dihHXg/8QeDw1u' WHERE user_id = '2019390018';
UPDATE app_user SET password_salt = '0wvj0CZZM6TgmQJa', password_pepper = '40zfnBlEMufMsTP6', password_hash = '$2y$10$JLR3u0Jrs9AzLDz5pCy3Re/OWil/W9KnkpdrniUSDnt1nxc6q0Bfm' WHERE user_id = '2020390008';
UPDATE app_user SET password_salt = 'nu9GXeZ6Yza5w3sO', password_pepper = 'j1Qq1Kx3aGYJzK4c', password_hash = '$2y$10$nId4d.wwDTgUaTL6FhhmZuHD33yMj9NufZAhiRG9r1UkRXw81IRw6' WHERE user_id = '2020390009';
UPDATE app_user SET password_salt = '2JGJfPMYuQO58DtT', password_pepper = 'WIsBUTce59YDLpZ2', password_hash = '$2y$10$Bebp0Fhokwx2DXvCyOrZ0.zP5w4eo6FG1lcRYpwbV9KPT9.RWxDG6' WHERE user_id = '2020390016';
UPDATE app_user SET password_salt = 'EVNoe7oU9tWfXWmb', password_pepper = 'UGSHAyrmzc9RhhJ2', password_hash = '$2y$10$v80mxsSRL6jilJHcPBgNmuJmY1BtISZqyvQcgqrTFEcTTRE5usWcK' WHERE user_id = '2020390017';
UPDATE app_user SET password_salt = 'MPzrRKy1UveJekkA', password_pepper = 'CHeowrY6XQ8qTmFi', password_hash = '$2y$10$vCZIkikcCu/Cb8/B.ANiCOET8wvN3bjd3FefjyU25Ccd9OpC.yqPm' WHERE user_id = '2020390018';
UPDATE app_user SET password_salt = '0iCMFCe6EoKjtEmZ', password_pepper = 'aUsnfQNawHk8gAvp', password_hash = '$2y$10$xcvNdD38YCjK.Tf.U7GjiuEsOu.PWA6CqAzwZAT/8wEZzE1Z5ZKQG' WHERE user_id = '2020390020';
UPDATE app_user SET password_salt = 'm30ZngPkQyEhaVOD', password_pepper = '5W1rCxqV2VSpjBnS', password_hash = '$2y$10$DjU7i30cNhJPmKwGvDc6VeSaJ7yQ7Ts4rkT5tQIomwf9Zqy5B/91q' WHERE user_id = '2021390001';
UPDATE app_user SET password_salt = 'ACwTiuG2aobXBpDV', password_pepper = 'l5JmHc0yx8u3ntAx', password_hash = '$2y$10$3y4xO3dCWG0fA9wU0dio1.rO0j/diQnbr9pwJduEei7bGuMDyAC/S' WHERE user_id = '2021390002';
UPDATE app_user SET password_salt = 'B4CFe41P9d4CKe8k', password_pepper = 'v4D0q330yrcgMxjF', password_hash = '$2y$10$TiHOYlzJXXg5fJ.xqWq.ouzHVWJGBnOc/QCGsECCr/PHJflic4wre' WHERE user_id = '2021390003';
UPDATE app_user SET password_salt = 'ODyH0TAFUQDkVOGC', password_pepper = 'oSGFkRk31xFZfzC7', password_hash = '$2y$10$QTI2v2tg9od52uE.fyz2Aeiw1bRwJMJsq8mg/0x5oEc7j5d736TxK' WHERE user_id = '2021390004';
UPDATE app_user SET password_salt = '2eoaJuvNArIyjZ58', password_pepper = '17BlyZlkTQgY5fsY', password_hash = '$2y$10$X1fs29kyP1DZxkl/3jvya.qM5u/YeFYeGCvoF9MWW7ksjXgGPBtQ2' WHERE user_id = '2021390005';
UPDATE app_user SET password_salt = 'j3YPWmQjz5j4WdfH', password_pepper = 'MvqVgI0OR1bVSCx6', password_hash = '$2y$10$mK/xpeOHJgiZbIbCiiO9deYfsnSuqP.MHZc.uQBKMU3Ha4Eb4Rssq' WHERE user_id = 'ADMIN01';
UPDATE app_user SET password_salt = 'xQEFRY188MW4sTcs', password_pepper = 'FZnhwETL7qnVvgwM', password_hash = '$2y$10$fDcQuHnz1rzfUN2YgDXTcePimlXRMiOYiN/htzGJUcVlTaMHkiCXO' WHERE user_id = 'CS01';
UPDATE app_user SET password_salt = 'CocUKcIN0rnSOeZ3', password_pepper = '0Ik6Ba5aG4K9Xn22', password_hash = '$2y$10$kmiFHW/ZeCf.blMXPUwb8u4nXWr4JFS/4BsWRax95PDYG3Ge7dASa' WHERE user_id = 'FET01';

-- ADD IS ADMIN CHECK FOR ALLOWING ALL REPOSITORY VIEWING
ALTER TABLE app_role ADD is_admin VARCHAR (1);
UPDATE app_role SET is_admin = 'T';
UPDATE app_role SET is_admin = 'Y' WHERE role_id = 1;

INSERT INTO study_program
VALUES
(99, 'FET Admin', 'FET'),
(98, 'FAS Admin', 'FAS'),
(97, 'FOB Admin', 'FOB'),
(96, 'FOE Admin', 'FOE');

DROP PROCEDURE get_publications;

DELIMITER //

CREATE PROCEDURE get_publications(IN user_id VARCHAR(50))
BEGIN
    SELECT p.publication_id, p.publication_title, p.publication_date, p.publication_abstract,
           pt.type_name, at.area_name, p.publication_owner
    FROM publication p
    INNER JOIN publication_authors pa ON p.publication_id = pa.publication_id
    INNER JOIN app_user au ON pa.user_id = au.user_id
    INNER JOIN app_user_role aur ON aur.user_id = au.user_id
    INNER JOIN app_role ar ON ar.role_id = aur.role_id
    INNER JOIN study_program sp ON au.program_id = sp.program_id
    INNER JOIN faculty f ON sp.faculty_id = f.faculty_id
    INNER JOIN publication_type pt ON p.type_id = pt.type_id
    INNER JOIN area_type at ON p.area_id = at.area_id
    WHERE (is_admin = 'Y') OR ((ar.role_id > (SELECT aur.role_id FROM app_user_role aur WHERE aur.user_id = user_id LIMIT 1)
           AND f.faculty_id = (SELECT sp.faculty_id FROM app_user WHERE user_id = user_id LIMIT 1))
          OR pa.user_id = user_id)
    GROUP BY p.publication_id, p.publication_title, p.publication_date, p.publication_abstract, pt.type_name, at.area_name
    ORDER BY p.publication_date DESC;
END //

DELIMITER ;