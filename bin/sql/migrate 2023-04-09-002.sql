USE publication_repo;

INSERT INTO publication_type (type_id, type_name) VALUES
(1, 'Books'),
(2, 'Journals'),
(3, 'Magazines'),
(4, 'Newspapers'),
(5, 'Research papers'),
(6, 'Conference papers'),
(7, 'Technical reports'),
(8, 'Theses and dissertations'),
(9, 'Government publications'),
(10, 'Annual reports'),
(11, 'Brochures and pamphlets'),
(12, 'Newsletters'),
(13, 'User manuals'),
(14, 'Catalogs'),
(15, 'White papers'),
(16, 'Case studies'),
(17, 'Web articles and blog posts'),
(18, 'Social media posts'),
(19, 'Audio recordings'),
(20, 'Video recordings');

INSERT INTO area_type (area_id, area_name) VALUES
(1, 'Artificial Intelligence'),
(2, 'Machine Learning'),
(3, 'Data Science'),
(4, 'Computer Vision'),
(5, 'Natural Language Processing'),
(6, 'Human-Computer Interaction'),
(7, 'Computer Networks'),
(8, 'Cybersecurity'),
(9, 'Database Systems'),
(10, 'Software Engineering'),
(11, 'Computer Graphics'),
(12, 'Computer Architecture'),
(13, 'Operating Systems'),
(14, 'Robotics'),
(15, 'Algorithm Design and Analysis'),
(16, 'Distributed Systems'),
(17, 'High-Performance Computing'),
(18, 'Computer Games and Animation'),
(19, 'Mobile and Web Applications Development'),
(20, 'Computer Science Education');

INSERT INTO publication (publication_id, publication_title, publication_date, lang, publication_abstract, doi, type_id, area_id, publication_ref, volume, issue, pages, series)
VALUES
('PUB-2201-001', 'Introduction to Machine Learning', '2022-01-01 00:00:00', 'English', 'This paper provides an overview of machine learning techniques and their applications.', '10.1234/abcd', 2, 1, 'IEEE Transactions on Knowledge and Data Engineering', 10, 2, '245-254', 'Lecture Notes in Computer Science'),
('PUB-2106-001', 'A Comparative Study of Deep Learning Models for Image Classification', '2021-06-15 00:00:00', 'English', 'This study compares the performance of several deep learning models on the task of image classification.', '10.5678/efgh', 2, 4, 'IEEE Transactions on Image Processing', 5, 3, '120-135', 'Advances in Neural Information Processing Systems'),
('PUB-2003-001', 'A Survey of Natural Language Processing Techniques', '2020-03-01 00:00:00', 'English', 'This paper surveys various natural language processing techniques and their applications.', '10.9012/ijkl', 2, 5, 'ACM Transactions on Natural Language Processing', 8, 1, '70-85', 'Lecture Notes in Computer Science'),
('PUB-2202-001', 'Exploring the Relationship Between Cybersecurity Threats and Social Media', '2022-02-20 00:00:00', 'English', 'This paper investigates the relationship between cybersecurity threats and social media usage.', NULL, 1, 8, 'Journal of Computer Security', 3, 2, '45-60', NULL),
('PUB-2108-001', 'A Comparative Study of Database Management Systems', '2021-08-10 00:00:00', 'English', 'This study compares the performance of several database management systems on various tasks.', '10.2468/mnop', 2, 9, 'ACM Transactions on Database Systems', 15, 4, '300-315', 'Advances in Database Technology');

INSERT INTO publication_authors 
VALUES
('PUB-2201-001', '2020390020'),
('PUB-2106-001', '2020390018'),
('PUB-2003-001', '2020390020'),
('PUB-2202-001', '2020390020'),
('PUB-2108-001', '2020390018');