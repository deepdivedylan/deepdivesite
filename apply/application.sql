DROP TABLE IF EXISTS application;
DROP TABLE IF EXISTS classes;

CREATE TABLE classes
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	className VARCHAR(64) NOT NULL,
	startDate DATE NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE application
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	createDate TIMESTAMP DEFAULT NOW(),
	classId INT UNSIGNED NOT NULL,
	fullName VARCHAR(64) NOT NULL,
	phoneNumber VARCHAR(64) NOT NULL,
	emailAddress VARCHAR(64) NOT NULL,
	gender CHAR(1) NOT NULL,
	birthday DATE NOT NULL,
	browser VARCHAR(192) NOT NULL,
	ipAddress VARBINARY(64) NOT NULL,
	howHeard VARCHAR(32),
	skype VARCHAR(32),
	google VARCHAR(32),
	aboutYourself TEXT,
	whyAttend TEXT,
	otherLinks TEXT,
	progExperience TEXT,
	FOREIGN KEY(classId) REFERENCES classes(id),
	PRIMARY KEY(id)
);

INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2013-10-14');
INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2014-01-06');
INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2014-03-24');
INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2014-06-02');
INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2014-08-11');
INSERT INTO classes(className, startDate) VALUES('Web Development/PHP', '2014-10-20');