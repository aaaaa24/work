CREATE TABLE city (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20),
  citycode VARCHAR(15),
  create_timestamp TIMESTAMP NOT NULL,
  update_timestamp TIMESTAMP NOT NULL
);