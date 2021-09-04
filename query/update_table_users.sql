UPDATE users SET
  user_id = CEIL(RAND() * 10000),
  create_timestamp = ADDTIME(CONCAT_WS(' ','2014-01-01' + INTERVAL RAND() * 180 DAY, '00:00:00'), SEC_TO_TIME(FLOOR(0 + (RAND() * 86401))));
