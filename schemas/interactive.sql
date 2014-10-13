CREATE TABLE feedbacks
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	reply       INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	content     TEXT,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE feedback_reply
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	feedback_id INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	student_id  INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	content     TEXT,
	KEY feedback_id(feedback_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE comments
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	status     	INT NOT NULL DEFAULT 0,
	agency_id   INT NOT NULL DEFAULT 0,
	student_id  INT NOT NULL DEFAULT 0,
	reply      	INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	begin_str   VARCHAR(50) NOT NULL DEFAULT 0,
	end_str     VARCHAR(50) NOT NULL DEFAULT 0,
	content     TEXT,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
