CREATE TABLE large_area (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(10),
  prefecture_name VARCHAR(10),
  prefecture_id VARCHAR(10),
  create_timestamp TIMESTAMP NOT NULL,
  update_timestamp TIMESTAMP NOT NULL
);