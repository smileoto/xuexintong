CREATE TABLE news
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	read_cnt    INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	src         VARCHAR(255) NOT NULL DEFAULT '',
	remark      VARCHAR(255) NOT NULL DEFAULT '',
	img         VARCHAR(255) NOT NULL DEFAULT '',
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE daily_news
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	read_cnt    INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	src         VARCHAR(255) NOT NULL DEFAULT '',
	remark      VARCHAR(255) NOT NULL DEFAULT '',
	img         VARCHAR(255) NOT NULL DEFAULT '',
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE articles
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	read_cnt    INT NOT NULL DEFAULT 0,
	created_by  INT NOT NULL DEFAULT 0,
	modified_by INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	src         VARCHAR(255) NOT NULL DEFAULT '',
	remark      VARCHAR(255) NOT NULL DEFAULT '',
	img         VARCHAR(255) NOT NULL DEFAULT '',
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE introductions
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id INT NOT NULL DEFAULT 0,
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE contacts
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id INT NOT NULL DEFAULT 0,
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE teachers
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id INT NOT NULL DEFAULT 0,
	content text,
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE agency_images
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	filesize    INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	filename    VARCHAR(255) NOT NULL DEFAULT '',
	realpath    VARCHAR(255) NOT NULL DEFAULT '',
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE news_images
(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agency_id   INT NOT NULL DEFAULT 0,
	status      INT NOT NULL DEFAULT 0,
	filesize    INT NOT NULL DEFAULT 0,
	created_at  DATETIME NOT NULL DEFAULT 0,
	modified_at DATETIME NOT NULL DEFAULT 0,
	title       VARCHAR(255) NOT NULL DEFAULT '',
	filename    VARCHAR(255) NOT NULL DEFAULT '',
	realpath    VARCHAR(255) NOT NULL DEFAULT '',
	KEY agency_id(agency_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO article_categories(name,remark) VALUES('news', '机构动态'),('daily_news', '每日讯息'),('knowledge', '知识分享');
