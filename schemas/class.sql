CREATE TABLE classes
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	entity_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	name        VARCHAR(100) NOT NULL DEFAULT '',
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	detail  TEXT,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE courses
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	class_id    INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	hours       INT NOT NULL DEFAULT 0,
	num         INT NOT NULL DEFAULT 0,
	tuition     INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	name        VARCHAR(100) NOT NULL DEFAULT '',
	content     VARCHAR(255) NOT NULL DEFAULT '',
	time        VARCHAR(100) NOT NULL DEFAULT '',
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE students_courses
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	student_id  INT NOT NULL DEFAULT 0,
	course_id   INT NOT NULL DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE guests_courses
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	guest_id  INT NOT NULL DEFAULT 0,
	course_id INT NOT NULL DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE signup_infor
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id INT NOT NULL DEFAULT 0,
	content TEXT,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
