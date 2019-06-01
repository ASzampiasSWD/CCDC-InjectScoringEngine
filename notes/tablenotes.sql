CREATE DATABASE ccdc_ise;
USE ccdc_ise;

CREATE TABLE Category(
  group_id int NOT NULL,
  group_name varchar(50) NOT NULL,
  comp_start varchar(50),
  comp_end varchar(50),
  role int NOT NULL,
  PRIMARY KEY (group_id)
);

CREATE TABLE Team(
  team_id int NOT NULL AUTO_INCREMENT,
  group_id int NOT NULL,
  team_name varchar(30) NOT NULL UNIQUE,
  team_password varchar(12) NOT NULL,
  team_score int NOT NULL DEFAULT 0,
  creation_date varchar(50) NOT NULL,
  PRIMARY KEY (team_id),
  FOREIGN KEY (group_id) REFERENCES Category(group_id)
);

CREATE TABLE Inject(
  inject_id int NOT NULL AUTO_INCREMENT,
  group_id int NOT NULL,
  title varchar(200) NOT NULL,
  sent_by varchar(30) NOT NULL,
  deliver_to varchar(30) NOT NULL,
  message varchar(700) NOT NULL,
  location varchar(200) NOT NULL,
  points int NOT NULL,
  is_active varchar(1) NOT NULL,
  is_multi varchar(1) NOT NULL,
  duration int NOT NULL,
  start_time varchar(100),
  end_time varchar(100),
  PRIMARY KEY(inject_id),
  FOREIGN KEY (group_id) REFERENCES Category(group_id)
);

CREATE TABLE Submission(
  entry_id int NOT NULL AUTO_INCREMENT,
  team_id int NOT NULL,
  inject_id int NOT NULL,
  location varchar(200),
  init_submitted varchar(200) NOT NULL,
  title varchar(50) NOT NULL,
  filename varchar(100),
  user_text varchar(500),
  inject_score int DEFAULT 0,
  graded_by varchar(50) DEFAULT null,
  is_late varchar(1) NOT NULL,
  PRIMARY KEY (entry_id),
  FOREIGN KEY (inject_id) REFERENCES Inject(inject_id),
  FOREIGN KEY (team_id) REFERENCES Team(team_id)
);

CREATE TABLE Notification(
  not_id int NOT NULL AUTO_INCREMENT,
  group_id int NOT NULL,
  team_id int DEFAULT NULL,
  init_submitted varchar(200) NOT NULL,
  last_updated varchar(30),
  message varchar(100) NOT NULL,
  PRIMARY KEY (not_id),
  FOREIGN KEY (group_id) REFERENCES Category(group_id),
  FOREIGN KEY (team_id) REFERENCES Team(team_id)
);

CREATE TABLE Password_Change(
 passchange_id int NOT NULL AUTO_INCREMENT,
 team_id int NOT NULL,
 service varchar(25) NOT NULL,
 new_password varchar(50) NOT NULL,
 status varchar(1) NOT NULL,
 time_changed varchar(100),
 PRIMARY KEY (passchange_id),
 FOREIGN KEY (team_id) REFERENCES Team(team_id)
);

CREATE TABLE Service(
  service_id int NOT NULL AUTO_INCREMENT,
  team_id int NOT NULL,
  service_name varchar(40) NOT NULL,
  service_type varchar(40) NOT NULL,
  ip varchar(40) NOT NULL,
  port varchar(40) NOT NULL,
  is_graded varchar(1) NOT NULL,
  is_active varchar(1) DEFAULT 0,
  service_score int DEFAULT 0,
  PRIMARY KEY (service_id),
  FOREIGN KEY (team_id) REFERENCES Team(team_id)
);
