<?php

declare(strict_types=1);

define('FORMAT_DATE_SQL', 'Y-m-d');
define('FORMAT_TIME_SQL', 'G:i:s');
define('FORMAT_DATETIME_SQL', FORMAT_DATE_SQL . ' ' . FORMAT_TIME_SQL);

define('FORMAT_DATE_INPUT', 'Y-m-d');
define('FORMAT_TIME_INPUT', 'H:i');
define('FORMAT_DATETIME_INPUT', FORMAT_DATE_INPUT . 'T' . FORMAT_TIME_INPUT);
