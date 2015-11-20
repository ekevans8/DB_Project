#Insert Test Users
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('B-Dawg', 'Brenton', 'Smelser', '25', 'bsmels1@students.towson.edu', '$2y$10$xtYuAsiiwn2TQCMUvREJT.y7eXC/h6b7ZDG1vlOhNhJiLJgjGv6VW', '21040', '1');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('E-Dawg', 'Emily', 'Evans', '21', 'eevans7@studnets.towson.edu', '$2y$10$bp/WdkFArWpmfgCuvmzRje.cONMYbH2Jc1p4/dgrZj9FR2wy9Yz8G', '21252', '1');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('L-Dawg', 'Larry', 'McLovin', '19', 'McLovin@gmail.com', '$2y$10$bZJ4rakwZWdTJdjDWIawo..11PByJIQwr1C.3FJRnm.GLihVzgSaG', '21207', '2');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('M-Dawg', 'Miguel', 'Fernandez', '21', 'mferna6@students.towson.edu', '$2y$10$/8XGWtCMeXgYyl.Cvpw7P.89jix7OleKdaRPBXC0qJebso3iTAjFG', '21207', '1');
INSERT INTO user (username, firstName, lastName, age, email, password, zipcode, isModerator) VALUES ('S-Dawg', 'Shannon', 'Smith', '21', 'smith3@students.towson.edu', '$2y$10$xyZOdBaa/Gg/Cql0zDgSdOQde4P7jBFpBCcOS.gylV4j6BIjWZK7S', '21252', '1');

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
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('1', 'Taylor Swift', '1989-1-1', NULL, '19610');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('2', 'Maroon 5', '1999-01-01', NULL, '90001');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('3', 'Wiz Khalifa', '2006-01-01', NULL, '58701');
INSERT INTO artist (artistId, name, formDate, breakupDate, formationZipcode) VALUES ('4', 'Fall Out Boy', '2001-01-01', NULL, '60609');

#Insert Test Members
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('1', '1', '1989-01-01', NULL, 'Taylor Swift');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('2', '2', '1994-01-01', NULL, 'Adam Levine');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('3', '2', '1994-01-01', NULL, 'Jesse Carmichael');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('4', '2', '1994-01-01', NULL, 'Mickey Madden');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('5', '2', '1994-01-01', '2006-01-01', 'Ryan Dusick');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('6', '2', '2001-01-01', NULL, 'James Valentine');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('7', '2', '2006-01-01', NULL, 'Matt Flynn');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('8', '3', '2006-01-01', NULL, 'Cameron Jibril Thomaz');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('9', '4', '2001-01-01', NULL, 'Joe Trohman');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('10', '4', '2001-01-01', NULL, 'Pete Wentz');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('11', '4', '2001-01-01', NULL, 'Patrick Stump');
INSERT INTO member (memberId, artistId, joinDate, leaveDate, name) VALUES ('12', '4', '2001-01-01', NULL, 'Andy Hurley');

#Insert Test Favorates 
INSERT INTO favorite (username, artistId) VALUES ('L-Dawg', '2');
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
INSERT INTO album (albumId, title, recordLabel, releaseDate) VALUES ('1', '1989', 'Big Machine Records', '2014-10-27');
INSERT INTO album (albumId, title, recordLabel, releaseDate) VALUES ('2', 'Blacc Hollywood', 'Rostrum/Atlantic', '2014-08-14');

#Insert Test Songs
INSERT INTO song (songId, title, duration) VALUES ('1', 'Welcome To New York', '3.32');
INSERT INTO song (songId, title, duration) VALUES ('2', 'Blank Space', '3.51');
INSERT INTO song (songId, title, duration) VALUES ('3', 'Style', '3.51');
INSERT INTO song (songId, title, duration) VALUES ('4', 'Out of the Woods', '3.55');
INSERT INTO song (songId, title, duration) VALUES ('5', 'All You Had To Do Was Stay', '3.13');
INSERT INTO song (songId, title, duration) VALUES ('6', 'Shake It Off', '3.39');
INSERT INTO song (songId, title, duration) VALUES ('7', 'I Wish You Would', '3.27');
INSERT INTO song (songId, title, duration) VALUES ('8', 'Bad Blood', '3.31');
INSERT INTO song (songId, title, duration) VALUES ('9', 'Wildest Dreams', '3.40');
INSERT INTO song (songId, title, duration) VALUES ('10', 'How You Get The Girl', '4.07');
INSERT INTO song (songId, title, duration) VALUES ('11', 'This Love', '4.10');
INSERT INTO song (songId, title, duration) VALUES ('12', 'I know Places', '3.15');
INSERT INTO song (songId, title, duration) VALUES ('13', 'Clean', '4.31');
INSERT INTO song (songId, title, duration) VALUES ('14', 'Wounderland', '4.06');
INSERT INTO song (songId, title, duration) VALUES ('15', 'You Are In Love', '4.27');
INSERT INTO song (songId, title, duration) VALUES ('16', 'Hope', '5.25');
INSERT INTO song (songId, title, duration) VALUES ('17', 'We Dem Boyz', '3.45');
INSERT INTO song (songId, title, duration) VALUES ('18', 'Promises', '3.30');
INSERT INTO song (songId, title, duration) VALUES ('19', 'KK', '4.09');
INSERT INTO song (songId, title, duration) VALUES ('20', 'House In The Hills', '4.52');
INSERT INTO song (songId, title, duration) VALUES ('21', 'Ass Dope', '2.47');
INSERT INTO song (songId, title, duration) VALUES ('22', 'Raw', '3.38');
INSERT INTO song (songId, title, duration) VALUES ('23', 'Staying Out All Night', '4.18');

#Insert Test Tracklists
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '1', '1', '1');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '2', '1', '2');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '3', '1', '3');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '4', '1', '4');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '5', '1', '5');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '6', '1', '6');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '7', '1', '7');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '8', '1', '8');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '9', '1', '9');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '10', '1', '10');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '11', '1', '11');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '12', '1', '12');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '13', '1', '13');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '14', '1', '14');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('1', '15', '1', '15');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '16', '3', '1');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '17', '3', '2');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '18', '3', '3');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '19', '3', '4');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '20', '3', '5');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '21', '3', '6');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '22', '3', '7');
INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('2', '23', '3', '8');

#Insert Test Performances
INSERT INTO performance (performanceId, duration, venueId, date, title) VALUES ('1', '2.5', '3', '2015-10-11', 'Taylors Amazing tour');
INSERT INTO performance (performanceId, duration, venueId, date, title) VALUES ('2', '1.5', '2', '2015-11-20', 'Wiz Pops In');
INSERT INTO performance (performanceId, duration, venueId, date, title) VALUES ('3', '0.5', '1', '2014-09-10', 'Taylors Suprise');
INSERT INTO performance (performanceId, duration, venueId, date, title) VALUES ('4', '4', '7', '2015-08-23', 'Taylor and Wiz');

#Insert Test Performance Playlists
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '1', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '6', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '8', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '9', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '11', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '13', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('1', '14', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('2', '17', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('2', '21', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('2', '22', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('2', '20', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('2', '23', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '8', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '20', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '9', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '23', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '6', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '17', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '12', '1');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('4', '18', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('3', '22', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('3', '18', '3');
INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('3', '16', '3');

#Insert Test Attended Performances
INSERT INTO attended_performance (username, performanceId) VALUES ('B-Dawg', '1');
INSERT INTO attended_performance (username, performanceId) VALUES ('E-Dawg', '1');
INSERT INTO attended_performance (username, performanceId) VALUES ('L-Dawg', '1');
INSERT INTO attended_performance (username, performanceId) VALUES ('M-Dawg', '1');
INSERT INTO attended_performance (username, performanceId) VALUES ('S-Dawg', '1');
INSERT INTO attended_performance (username, performanceId) VALUES ('E-Dawg', '2');
INSERT INTO attended_performance (username, performanceId) VALUES ('L-Dawg', '2');
INSERT INTO attended_performance (username, performanceId) VALUES ('S-Dawg', '2');
INSERT INTO attended_performance (username, performanceId) VALUES ('M-Dawg', '2');
INSERT INTO attended_performance (username, performanceId) VALUES ('M-Dawg', '3');
INSERT INTO attended_performance (username, performanceId) VALUES ('M-Dawg', '4');
INSERT INTO attended_performance (username, performanceId) VALUES ('L-Dawg', '3');
INSERT INTO attended_performance (username, performanceId) VALUES ('L-Dawg', '4');

#Insert Test Comments
INSERT INTO comment (commentId, username, artistId, comment, postDate) VALUES ('1', 'M-Dawg', '3', 'The Dopest', '2015-11-20');
INSERT INTO comment (commentId, username, artistId, comment, postDate) VALUES ('2', 'L-Dawg', '3', 'Roll One, Smoke one!', '2015-11-19');
INSERT INTO comment (commentId, username, artistId, comment, postDate) VALUES ('3', 'B-Dawg', '1', 'Too Sexy ;)', '2015-11-20');
INSERT INTO comment (commentId, username, performanceId, comment, postDate) VALUES ('4', 'B-Dawg', '1', 'The BEST EVER!!!! Love you Taylor! Call me maybe?', '2015-11-20');
INSERT INTO comment (commentId, username, artistId, comment, postDate) VALUES ('5', 'E-Dawg', '1', 'I love her hair!', '2015-11-10');
INSERT INTO comment (commentId, username, performanceId, comment, postDate) VALUES ('6', 'E-Dawg', '1', 'YESSS Taylor is the best idc what all you lames say :P', '2015-11-18');
INSERT INTO comment (commentId, username, performanceId, comment, postDate) VALUES ('7', 'S-Dawg', '2', 'Was an enjoyable performance.', '2015-10-19');
INSERT INTO comment (commentId, username, performanceId, comment, postDate) VALUES ('8', 'L-Dawg', '4', 'Not a huge fan of Taylor Swift with she was nice paired with Wiz. Well played.', '2015-11-17');
INSERT INTO comment (commentId, username, artistId, comment, postDate) VALUES ('9', 'M-Dawg', '4', 'You will remember me for Centuries!!!!!', '2015-10-09');
