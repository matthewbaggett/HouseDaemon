DROP VIEW balances_unconfirmed;
CREATE VIEW balances_unconfirmed AS
SELECT 
  t.account_id,
  u.username,
  u.user_id,
  SUM(t.amount) as `balance`,
  a.`coin_id` as `coin_id`,
  c.`name` as `coin_name`
FROM transactions t
JOIN accounts a
  ON a.account_id = t.account_id
JOIN users u
  ON a.user_id = u.user_id
JOIN coins c
  ON c.coin_id = a.coin_id
WHERE confirmations < 10
GROUP BY t.account_id;

DROP VIEW balances_confirmed;
CREATE VIEW balances_confirmed AS
SELECT 
  t.account_id,
  u.username,
  u.user_id,
  SUM(t.amount) as `balance`,
  a.`coin_id` as `coin_id`,
  c.`name` as `coin_name`
FROM transactions t
JOIN accounts a
  ON a.account_id = t.account_id
JOIN users u
  ON a.user_id = u.user_id
JOIN coins c
  ON c.coin_id = a.coin_id
WHERE confirmations >= 10
GROUP BY t.account_id