<?php

use PhangoApp\PhaRouter\Routes;

#Routes::$urls['shop\/viewproduct\/([0-9]+)']=array('viewproduct', 'home');

Routes::$urls['pages\/([A-Za-z0-9_-]+)']=['index', 'home'];
Routes::$urls['pages\/([0-9]+)']=['index', 'home'];


?>
