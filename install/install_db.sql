DROP DATABASE IF EXISTS spmsdb;
CREATE DATABASE IF NOT EXISTS  spmsdb;

CREATE USER IF NOT EXISTS 'spms'@'localhost' IDENTIFIED BY PASSWORD '*071C831D975A8E3E0E95F396F0966C8EFB198E7D';

GRANT ALL PRIVILEGES ON spmsdb.* TO 'spms'@'localhost';

use spmsdb;

CREATE TABLE IF NOT EXISTS company (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(256) NOT NULL,
	companyCode VARCHAR(64) UNIQUE,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8 ;

INSERT INTO company (name, companyCode, isValid) VALUES("company A","COMP_0001",1);

CREATE TABLE IF NOT EXISTS department (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(256) NOT NULL,
	departmentCode VARCHAR(64) UNIQUE, 
	companyId	INT NULL,
	parentId	INT NULL,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8 ;
INSERT INTO department (name, departmentCode, companyId) VALUES("Lab A", "DEPT_001", 1);

CREATE TABLE IF NOT EXISTS users ( 
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email		VARCHAR(256) NOT NULL,
	name		VARCHAR(256) NOT NULL,
	password	VARCHaR(256) NOT NULL,
	role		ENUM('admin', 'user', 'guest') NOT NULL DEFAULT 'user',
	userCode	VARCHAR(64) NULL,
	departmentId INT NULL,
	companyId	INT NULL,
	parentId	INT NULL,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8 ;

INSERT INTO users (name, email, password, role, userCode, departmentId, companyId) VALUES("Admin","neinnil09@gmail.com", PASSWORD("admin"),"admin", "USER_0001", 1,1);
INSERT INTO users (name, email, password, role, userCode, departmentId, companyId) VALUES("Guest","guest@gmail.com", PASSWORD("guest"),"guest", "USER_0002", 1,1);

CREATE TABLE IF NOT EXISTS project (
	id			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(256) NOT NULL,
	projectCode	VARCHAR(64) NOT NULL,
	parentId	INT,
	description	TEXT,
	startDate	DATE NOT NULL,
	endDate		DATE NOT NULL,
	actualStartDate		DATE ,
	actualEndDate		DATE ,
	status		TINYINT,
	projectManager	INT,
	projectLeaders	TINYINT UNSIGNED,
	numbOfWorkers	SMALLINT UNSIGNED,
	numbOfTasks		SMALLINT UNSIGNED,
	numbOfRealTasks	SMALLINT UNSIGNED,
	estimatedCost	INT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS task (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(256) NOT NULL,
	projectId	INT NOT NULL,
	parentId	INT,
	taskId		INT,
	parentTaskId	INT,
	upTaskId	INT,
	downTaskId	INT,
	level		TINYINT,
	wbs		TINYTEXT,
	assigneeId	INT,
	startDate	TIMESTAMP,
	endDate		TIMESTAMP,
	duration	VARCHAR(32),
	progress	TINYINT,
	actualStartDate	TIMESTAMP,
	actualEndDate	TIMESTAMP,
	precedenceTasks	TEXT,
	successorTasks	TEXT,
	isMilestone		VARCHAR(8),
	isTaskGroup		TINYINT,
	note	TEXT,

	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS material (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(256) NOT NULL,
	partno		VARCHAR(256) NOT NULL,
	type		VARCHAR(64),
	specData	TEXT,
	parentId	INT,
	taskId		INT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;


CREATE TABLE IF NOT EXISTS location (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(256) NOT NULL,
	parentId	INT,
	address		TEXT,
	specData	TEXT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS progIndicators (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	parentId	INT,
	progressId	INT,
	projectId	INT,
	taskId		INT,
	modifier	INT,
	value		TINYINT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS resources (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name	VARCHAR(256) NOT NULL,
	parentId	INT,
	projectId	INT,
	resourceId	INT,
	type		ENUM('worker','material', 'location') NOT NULL DEFAULT 'worker',
	role		ENUM('project manager', 'project leader', 'labour','observer','material','location') NOT NULL DEFAULT 'labour',
	privileges	EnUM('readonly', 'readwrite'),
	amount		INT,
	cost		INT,
	overtimeCost	INT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS issues (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name	VARCHAR(256) NOT NULL,
	parentId	INT,
	projectId	INT,
	taskId	INT,
	userId INT,
	assigneeId	INT,
	duedate DATETIME,
	title		TINYTEXT NOT NULL,
	description	TEXT,
	status		TINYINT,
	severity TINYINT,
	priority TINYINT,
	tag			TEXT,
	attachements	TEXT,
	closeddate DATETIME,
	rootCause	TEXT,
	response	TEXT,
	comment TEXT,
	prevent	TEXT,
	
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS attachment ( 
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name	VARCHAR(256) NOT NULL,
	parentId	INT,
	projectId	INT,
	taskId		INT,
	path	VARCHAR(4096),
	backupPath	VARCHAR(4096),
	tableName	VARCHAR(256),
	type		SMALLINT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS calendar ( 
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name	VARCHAR(256) NOT NULL,
	projectId	INT,
	parentId	INT,
	weekdays	TEXT, #JSON CHECK(JSON_VALID(weekdays)),
	exceptions	TEXT, #JSON CHECK(JSON_VALID(exceptions)),
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS note (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name	VARCHAR(256) NOT NULL,
	projectId	INT,
	taskId		INT,
	parentId	INT,
	userId	INT,
	departmentId	INT,
	writer		INT,
	workingtime TIME,
	today	TEXT,
	nextday TEXT,
	attachedObjs	TEXT,
	status		INT,
	revision	INT,
	type		TINYINT,
	createdDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modifiedDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	isValid TINYINT DEFAULT 1
) engine=InnoDB default charset utf8;

CREATE TABLE IF NOT EXISTS activities (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userid INT,
	type	TINYINT,
	typename	VARCHAR(128),
	content		TEXT, #JSON CHECK(JSON_VALID(content)),
	createdDate	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP	
) engine=InnoDB default charset utf8;
