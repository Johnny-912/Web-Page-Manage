DROP TABLE IF EXISTS User, Assignment, Feedback;

CREATE TABLE User (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    date_of_birth VARCHAR(255),
    avatar_url VARCHAR(255),
    PRIMARY KEY (user_id)
); 

CREATE TABLE Assignment (
    asg_id INT NOT NULL AUTO_INCREMENT,
    user_id INT,
    asgn VARCHAR(255),
    course VARCHAR(255),
    due_date VARCHAR(255),
    instructor VARCHAR(255),
    status VARCHAR(255),
    PRIMARY KEY (asg_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id)
);

CREATE TABLE Feedback (
    feedback_id INT NOT NULL AUTO_INCREMENT,
    asg_id INT,
    user_id INT,
    comment VARCHAR(1500),
    time_stamp DATETIME,
    PRIMARY KEY (feedback_id),
    FOREIGN KEY (asg_id) REFERENCES Assignment (asg_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id)
);
