CREATE TABLE assignment_one
(
    employee_id    INT NOT NULL,
    -- user-provided ID; must be a whole number

    employee_name  VARCHAR(255) NOT NULL,
    -- employee names can be up to 255 characters long

    week_worked    DATE NOT NULL,
    -- stores the week worked as a date

    hours_worked   INT NOT NULL,
    -- stores the number of hours worked as an int

    PRIMARY KEY (employee_id)
    -- primary key will prevent duplicate employee_id entries
);
