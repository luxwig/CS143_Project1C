SOURCE drop.sql

CREATE TABLE Movie (
	id int,
	title varchar(100) NOT NULL,  -- The movie must have a title 
	year int,
	rating varchar(10),
	company varchar(50),
	PRIMARY KEY(id)
	) ENGINE = INNODB;

CREATE TABLE Actor (
	id int,
	last varchar(20),
	first varchar(20),
	sex varchar(6),
	dob date NOT NULL, -- Every actor must have a dob
	dod date,
	PRIMARY KEY(id), -- Actor id must be unique
	CHECK(sex='male' OR sex='female'),
	CHECK (dod > dob)
	) ENGINE = INNODB;

CREATE TABLE Director (
	id int,
	last varchar(20),
	first varchar(20),
	dob date NOT NULL, -- Every director must have a dob
	dod date,
	PRIMARY KEY(id), -- director id must be unique
	CHECK (dod > dob)
	) ENGINE = INNODB;

CREATE TABLE MovieGenre (
	mid int,
	genre varchar(20),
	FOREIGN KEY(mid) references Movie(id)
	) ENGINE = INNODB;

CREATE TABLE MovieDirector (
	mid int,
	did int,
	FOREIGN KEY(mid) references Movie(id),
	FOREIGN KEY(did) references Director(id)
	) ENGINE = INNODB;

CREATE TABLE MovieActor (
	mid int,
	aid int,
	role varchar(50),
	FOREIGN KEY (mid) references Movie(id),
	FOREIGN KEY (aid) references Actor(id)
	) ENGINE = INNODB;

CREATE TABLE Review (
	name varchar(20),
	time timestamp,
	mid int,
	rating int,
	comment varchar(500),
	FOREIGN KEY(mid) references Movie(id)
	) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
	id int
	) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
	id int
	) ENGINE = INNODB;

CREATE TRIGGER inc_persona AFTER INSERT ON Actor
FOR EACH ROW 
	UPDATE MaxPersonID SET id=id+1;


CREATE TRIGGER inc_persond AFTER INSERT ON Director
FOR EACH ROW 
	UPDATE MaxPersonID SET id=id + 1;



CREATE TRIGGER inc_movie AFTER INSERT ON Movie
FOR EACH ROW
UPDATE MaxMovieID SET id = id + 1;

INSERT INTO MaxPersonID VALUES (0);
INSERT INTO MaxMovieID VALUES (0);

CREATE VIEW Tca(id, first,last,sex,dob,dod, max) as select * from Actor, MaxPersonID;
CREATE VIEW Rid(id, first,last,dob,dod, max) as select * from Director, MaxMovieID;
