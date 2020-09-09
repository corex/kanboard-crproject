<?php

namespace Kanboard\Plugin\CRProject\Schema;

use PDO;

const VERSION = 3;

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
        "is_hidden" INTEGER NOT NULL DEFAULT "0"
    )');
}

function version_2(PDO $pdo)
{
    $pdo->exec('ALTER TABLE crproject_has_status ADD COLUMN is_focused INTEGER NOT NULL DEFAULT "0"');
}

function version_3(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS crproject_platform (
        "id" SERIAL PRIMARY KEY,
        "title" VARCHAR(50) NOT NULL,
        "color_id" VARCHAR(50) NULL
    )');

    $pdo->exec('ALTER TABLE crproject_has_status ADD COLUMN platform_id INTEGER NOT NULL DEFAULT "0"');
}
