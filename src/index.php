<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo loadView('index', ['pagetitle' => 'Titre de la page', 'name' => $_GET['name'] ?? '']);
