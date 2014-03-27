DROP VIEW peers_per_wallet;
CREATE VIEW peers_per_wallet AS
SELECT 
	c.`name` as coin,
	COUNT(np.network_peer_id) as peers
FROM network_peers np 
JOIN wallets w
  ON np.wallet_id = w.wallet_id
JOIN coins c
  ON w.coin_id = c.coin_id
GROUP BY np.wallet_id