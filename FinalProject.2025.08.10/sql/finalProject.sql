CREATE TABLE users_final_project
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50)  NOT NULL UNIQUE,
    password        VARCHAR(128) NOT NULL,
    firstName       VARCHAR(128) NOT NULL,
    lastName        VARCHAR(128) NOT NULL,
    emailAddress    VARCHAR(128) NOT NULL
);