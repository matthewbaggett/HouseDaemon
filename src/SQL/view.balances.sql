DROP VIEW balances;
DROP VIEW balances_unconfirmed;
CREATE VIEW balances_unconfirmed AS
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
GROUP BY t.account_id;

DROP VIEW balances_confirmed;
CREATE VIEW balances_confirmed AS
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
WHERE confirmations >= 10
GROUP BY t.account_id