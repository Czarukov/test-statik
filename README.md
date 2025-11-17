Query voor TimeSeries graph:

SQL: 

WITH RECURSIVE date_series AS (
    SELECT '2025-01-01' AS day
    UNION ALL
    SELECT day + INTERVAL 1 DAY
    FROM date_series
    WHERE day + INTERVAL 1 DAY <= '2025-01-31'
)
SELECT
    ds.day,
    COUNT(v.id) AS visitor_count
FROM date_series ds
LEFT JOIN visitors v
    ON DATE(v.created_at) = ds.day
GROUP BY ds.day
ORDER BY ds.day
LIMIT 100;