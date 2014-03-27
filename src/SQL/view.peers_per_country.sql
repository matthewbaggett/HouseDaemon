DROP VIEW peers_per_country;
CREATE VIEW peers_per_country AS
SELECT 
	l.country as `country`,
	c.`name` as `coin`,
	COUNT(np.network_peer_id) as `peers`
	
FROM network_peers np 
JOIN wallets w
  ON np.wallet_id = w.wallet_id
JOIN coins c
  ON w.coin_id = c.coin_id
LEFT JOIN locations l
  ON l.address = np.address
WHERE l.country IS NOT NULL
GROUP BY coin, l.country
ORDER BY peers DESC