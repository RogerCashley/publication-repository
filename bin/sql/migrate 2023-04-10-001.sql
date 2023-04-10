DROP VIEW vw_publication_card;
DROP VIEW vw_publication_detail;

CREATE VIEW vw_app_user_roles
AS
  SELECT
    u.user_id,
    u.email,
    ur.role_id,
    u.full_name,
    r.role_name
  FROM
    app_user u
    JOIN app_user_role ur ON u.user_id = ur.user_id
    JOIN app_role r ON ur.role_id = r.role_id;

CREATE VIEW vw_app_user
AS
  SELECT
    u.user_id, u.full_name, u.email, p.program_name, f.faculty_id, f.faculty_name, r.role_name
  FROM app_user u
    LEFT JOIN study_program p ON u.program_id = p.program_id
    LEFT JOIN faculty f ON p.faculty_id = f.faculty_id
    LEFT JOIN app_user_role ur ON u.user_id = ur.user_id
    LEFT JOIN app_role r ON ur.role_id = r.role_id;

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
    WHERE (ar.role_id > (SELECT aur.role_id FROM app_user_role aur WHERE aur.user_id = user_id LIMIT 1)
           AND f.faculty_id = (SELECT sp.faculty_id FROM app_user WHERE user_id = user_id LIMIT 1))
          OR pa.user_id = user_id
    GROUP BY p.publication_id, p.publication_title, p.publication_date, p.publication_abstract, pt.type_name, at.area_name
    ORDER BY p.publication_date DESC;
END //

DELIMITER ;

CREATE VIEW vw_publication AS
SELECT p.publication_id, p.publication_title, p.publication_date, p.lang, p.publication_abstract, p.doi, p.type_id, pt.type_name, p.area_id, at.area_name, p.publication_ref, p.volume, p.issue, p.pages, p.series, pc.content_file, p.publication_owner, GROUP_CONCAT(a.full_name SEPARATOR ', ') as authors
FROM publication p
JOIN publication_type pt ON p.type_id = pt.type_id
JOIN area_type at ON p.area_id = at.area_id
LEFT JOIN publication_content pc ON p.publication_id = pc.publication_id
LEFT JOIN publication_authors pa ON p.publication_id = pa.publication_id
LEFT JOIN app_user a ON pa.user_id = a.user_id
GROUP BY p.publication_id, p.publication_title, p.publication_date, p.lang, p.publication_abstract, p.doi, p.type_id, pt.type_name, p.area_id, at.area_name, p.publication_ref, p.volume, p.issue, p.pages, p.series, pc.content_file
ORDER BY a.full_name ASC;

ALTER TABLE publication ADD publication_owner VARCHAR (50);
UPDATE publication SET publication_owner = '2020390020';