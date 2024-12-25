<?php

$config = parse_ini_file('../../config.ini', true);
$dsn = $config['dsn'];
$db = new \PDO($dsn, $username, $password);
