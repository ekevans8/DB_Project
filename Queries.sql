#Insert Test Users
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('B-Dawg', 'Brenton', 'Smelser', '25', 'bsmels1@students.towson.edu', '$2y$10$xtYuAsiiwn2TQCMUvREJT.y7eXC/h6b7ZDG1vlOhNhJiLJgjGv6VW', '21040', '0');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('E-Dawg', 'Emily', 'Evans', '21', 'eevans7@studnets.towson.edu', '$2y$10$bp/WdkFArWpmfgCuvmzRje.cONMYbH2Jc1p4/dgrZj9FR2wy9Yz8G', '21252', '0');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('L-Dawg', 'Larry', 'McLovin', '19', 'McLovin@gmail.com', '$2y$10$bZJ4rakwZWdTJdjDWIawo..11PByJIQwr1C.3FJRnm.GLihVzgSaG', '21207', '1');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('M-Dawg', 'Miguel', 'Fernandez', '21', 'mferna6@students.towson.edu', '$2y$10$/8XGWtCMeXgYyl.Cvpw7P.89jix7OleKdaRPBXC0qJebso3iTAjFG', '21207', '0');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('S-Dawg', 'Shannon', 'Smith', '21', 'smith3@students.towson.edu', '$2y$10$xyZOdBaa/Gg/Cql0zDgSdOQde4P7jBFpBCcOS.gylV4j6BIjWZK7S', '21252', '0');

#Insert Test Venues
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Pier Six Box Office', '731 Eastern Ave', 'Baltimore', 'MD', '21202');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Rams Head Live!', '20 Market PL', 'Baltimore', 'MD', '21202');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('The Fillmore Silver Spring', '8656 Colesville Rd', 'Silver Spring', 'MD', '20910');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Baltimore Soundstage', '124 Market Pl', 'Baltimore', 'MD', '21202');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Echostage', '2135 Queens Chapel Rd NE', 'Washington', 'DC', '20018');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Ottobar', '2549 N Howard St', 'Baltimore', 'MD', '21218');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Jiffy Lube Live', '7800 Cellar Door Dr', 'Bristow', 'VA', '20136');
INSERT INTO venue (name, streetAddress, city, state, zipcode) VALUES ('Black Cat', '1811 14th St NW', 'Washington', 'DC', '20009');

#Insert Test Artists/GROUPS
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('0', 'Taylor Swift', '1989-1-1', NULL, '19610');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('1', 'Maroon 5', '1999-01-01', NULL, '90001');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('3', 'Wiz Khalifa', '2006-01-01', NULL, '58701');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('4', 'Fall Out Boy', '2001-01-01', NULL, '60609');

#Insert Test Members
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('0', '2', '1989-01-01', NULL, 'Taylor Swift');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('1', '2', '1994-01-01', NULL, 'Adam Levine');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('2', '2', '1994-01-01', NULL, 'Jesse Carmichael');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('3', '2', '1994-01-01', NULL, 'Mickey Madden');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('4', '2', '1994-01-01', NULL, '2006-01-01', 'Ryan Dusick');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('5', '2', '2001-01-01', NULL, 'James Valentine');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('6', '2', '2006-01-01', NULL, 'Matt Flynn');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('7', '3', '2006-01-01', NULL, 'Cameron Jibril Thomaz');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('8', '4', '2001-01-01', NULL, 'Joe Trohman');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('9', '4', '2001-01-01', NULL, 'Pete Wentz');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('10', '4', '2001-01-01', NULL, 'Patrick Stump');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('11', '4', '2001-01-01', NULL, 'Andy Hurley');

#Insert Test Favorates 
INSERT INTO favorite (username, artistId) VALUES ('L-Dawg', '1');
INSERT INTO favorite (username, artistId) VALUES ('L-Dawg', '3');
INSERT INTO favorite (username, artistId) VALUES ('B-Dawg', '2');
INSERT INTO favorite (username, artistId) VALUES ('B-Dawg', '4');
INSERT INTO favorite (username, artistId) VALUES ('E-Dawg', '1');
INSERT INTO favorite (username, artistId) VALUES ('E-Dawg', '2');
INSERT INTO favorite (username, artistId) VALUES ('E-Dawg', '3');
INSERT INTO favorite (username, artistId) VALUES ('S-Dawg', '1');
INSERT INTO favorite (username, artistId) VALUES ('S-Dawg', '2');
INSERT INTO favorite (username, artistId) VALUES ('S-Dawg', '3');
INSERT INTO favorite (username, artistId) VALUES ('S-Dawg', '4');
INSERT INTO favorite (username, artistId) VALUES ('M-Dawg', '2');
INSERT INTO favorite (username, artistId) VALUES ('M-Dawg', '3');
INSERT INTO favorite (username, artistId) VALUES ('M-Dawg', '4');

#Insert Test Albums
INSERT INTO album (albumId, title, recordLabel, releaseDate) VALUES ('0', '1989', 'Big Machine Records', '2014-10-27');


#Insert Test Songs
