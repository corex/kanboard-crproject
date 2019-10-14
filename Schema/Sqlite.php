<?php

namespace Kanboard\Plugin\CRProject\Schema;

use PDO;

const VERSION = 2;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS crproject_status (
        "id" SERIAL PRIMARY KEY,
        "title" VARCHAR(50) NOT NULL,
        "description" VARCHAR(200),
        "is_visible" INTEGER NOT NULL DEFAULT "1",
        "position" INTEGER NOT NULL DEFAULT "0",
        "color_id" VARCHAR(50) NULL
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS crproject_has_status (
        "id" SERIAL PRIMARY KEY,
        "project_id" INTEGER NOT NULL,
        "status_id" INTEGER NOT NULL DEFAULT "0",
        "is_hidden" INTEGER NOT NULL DEFAULT "0",
        "is_focused" INTEGER NOT NULL DEFAULT "0"
    )');
}
