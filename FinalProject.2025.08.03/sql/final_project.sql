CREATE TABLE users_final_project
(
    user_id         INT             AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50)     NOT NULL UNIQUE,
    password        VARCHAR(128)    NOT NULL,
    first_name      VARCHAR(128)    NOT NULL,
    last_name       VARCHAR(128)    NOT NULL,
    email_address   VARCHAR(128)    NOT NULL UNIQUE,
    phone_number    VARCHAR(20)     NOT NULL UNIQUE,
    photo           VARCHAR(255)    DEFAULT NULL,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);