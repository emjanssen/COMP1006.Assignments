CREATE TABLE assignment_one
(
    -- defines four columns: id, name, date, hours
    employee_id    INT          NOT NULL AUTO_INCREMENT,
    --each new row gets new id; will increment automatically
    employee_name  VARCHAR(255) NOT NULL,
    --names can have a max length of 255 characters
    date_worked  DATE         NOT NULL,
    -- date data type
    hours_worked int          NOT NULL,
    -- hours can be up to two digits but no higher
    PRIMARY KEY (employee_id)
    -- assigns id as the primary key
);
