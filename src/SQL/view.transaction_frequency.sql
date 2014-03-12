DROP VIEW transaction_frequency;
CREATE VIEW transaction_frequency AS
SELECT
  COUNT(t.transaction_id) as `frequency`,
  DATE_FORMAT(t.`date`, '%Y-%m-%d %H\:00\:00') as `time_period`
FROM transactions t
GROUP BY `time_period`
ORDER BY `time_period` DESC