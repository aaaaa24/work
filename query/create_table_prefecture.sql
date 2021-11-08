CREATE TABLE prefecture (
  prefecture_id VARCHAR(3) PRIMARY KEY,
  name VARCHAR(15),
  create_timestamp TIMESTAMP NOT NULL,
  update_timestamp TIMESTAMP NOT NULL
);