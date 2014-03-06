DROP VIEW balances;
CREATE VIEW balances AS
SELECT 
t.account_id,
u.username,
u.user_id,
SUM(t.amount) as balance
FROM transactions t
JOIN accounts a
  ON a.account_id = t.account_id
JOIN users u
  ON a.user_id = u.user_id
GROUP BY t.account_id