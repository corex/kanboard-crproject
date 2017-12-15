<?php

namespace Kanboard\Plugin\CRProject\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS crproject_status (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(50) NOT NULL,
        is_visible INT NOT NULL DEFAULT '1',
        position INT NOT NULL DEFAULT '0',
        color_id VARCHAR(50) NULL,
        is_default INT NOT NULL DEFAULT '0',
        PRIMARY KEY(id)
    ) ENGINE=InnoDB CHARSET=utf8");

    $pdo->exec("CREATE TABLE IF NOT EXISTS crproject_has_status (
        id INT NOT NULL AUTO_INCREMENT,
        project_id INTEGER NOT NULL,
        status_id INT NOT NULL DEFAULT '0',
        is_hidden INT NOT NULL DEFAULT '0',
        PRIMARY KEY(id)
    ) ENGINE=InnoDB CHARSET=utf8");
}
