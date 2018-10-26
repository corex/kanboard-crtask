<?php

namespace Kanboard\Plugin\CRTask\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS crtask_color (
        "id" SERIAL PRIMARY KEY,
        "color_id" VARCHAR(50) NOT NULL,
        "title" VARCHAR(50) NOT NULL,
        "position" INTEGER NOT NULL
    ) ENGINE=InnoDB CHARSET=utf8');
}
