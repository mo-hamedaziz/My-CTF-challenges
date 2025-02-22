<?php
$cronJob = "*/30 * * * * chmod -R 644 /var/www/html/uploads/* && find /var/www/html/uploads/ -type f ! -name 'flag.txt' -delete && chmod 000 /var/www/html/uploads/flag.txt\n";

$cronFile = "/tmp/cleanup_cron";

file_put_contents($cronFile, $cronJob);
exec("crontab $cronFile");
unlink($cronFile);

echo "Cron job successfully set up to clean uploads folder every 30 minutes except flag.txt.";
?>
