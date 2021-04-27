<html>
<body>
<h2> Hello NGINX / PHP </h2>
<?php
$ip = getenv('REMOTE_ADDR', true) ?: getenv('REMOTE_ADDR');
echo $ip;

$mysql-server = getenv('MYSQL_HOSTNAME', true) ?: getenv('MYSQL_HOSTNAME');
?>
</body>
</html>