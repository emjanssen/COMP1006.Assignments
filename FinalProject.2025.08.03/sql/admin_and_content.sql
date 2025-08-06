-- fields available during user registration
CREATE TABLE final_project_admin
(
    user_id       INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password      VARCHAR(128) NOT NULL,
    first_name    VARCHAR(128) NOT NULL,
    last_name     VARCHAR(128) NOT NULL,
    email_address VARCHAR(128) NOT NULL UNIQUE,
    phone_number  VARCHAR(20)  NOT NULL UNIQUE,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- fields to manage user-added content
CREATE TABLE final_project_content
(
    content_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT          NOT NULL,
    user_title VARCHAR(255) NOT NULL,
    user_body  TEXT         NOT NULL,
    user_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES final_project_admin (user_id) ON DELETE CASCADE
);
