<?php
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/promac/");
define('NOMESIS', "PROMAC");
define('SMTP', 'no.replay@teste.com');
define('SENHASMTP', 'senha');
date_default_timezone_set('America/Fortaleza');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos