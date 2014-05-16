DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS user;

CREATE TABLE user
(
	id INT UNSIGNED	NOT NULL AUTO_INCREMENT,
	email VARCHAR(64) NOT NULL,
	password CHAR(128) NOT NULL,
	salt CHAR(64) NOT NULL,
	UNIQUE(email),
	PRIMARY KEY(id)
);

CREATE TABLE posts
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(128) NOT NULL,
	author VARCHAR(128) NOT NULL,
	text TEXT NOT NULL,
	date TIMESTAMP,
	INDEX(title),
        INDEX(author),
	PRIMARY KEY(id)
);


