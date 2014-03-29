DROP VIEW exchange_rate;
CREATE VIEW exchange_rate AS
SELECT 
vb.`valuation_batch_id` as `batch_id`,
vb.`updated` as `date`,
v1.`source` as `source`,
v1.`from` as `input`,
v2.`from` as `output`,
-- CONCAT(v1.`to`, "-", v2.`to`) as `via-both`,
CONCAT(v1.`to`) as `via`,
v1.`value` as `input_btc_value`,
v2.`value` as `output_btc_value`,
v1.`value` / v2.`value` as `rate`
FROM valuation_batches as vb
JOIN valuations v1
  ON vb.valuation_batch_id = v1.valuation_batch_id
JOIN valuations v2
  ON vb.valuation_batch_id = v2.valuation_batch_id
  AND v1.`to` = v2.`to`
  AND v1.`source` = v2.`source`
WHERE v1.`source` = 'Average'
--  AND v1.`from` = 'DOGE'

ORDER BY batch_id DESC, input ASC, output ASC