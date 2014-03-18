DROP VIEW transaction_density;
CREATE VIEW transaction_density AS
SELECT 
	t.account_id,
	t.address,
-- 	DATE_FORMAT(t.`date`, '%Y-%m-%d %H\:00\:00') as `time_period`,
	DATE_FORMAT(t.`date`, '%Y-%m-%d 00\:00\:00') as `time_period`,
	SUM(t.amount)
FROM transactions t
WHERE category = "receive"
GROUP BY t.address, time_period