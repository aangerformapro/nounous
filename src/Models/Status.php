<?php

declare(strict_types=1);

namespace Models;

enum Status: string
{
    case PENDING  = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case DECLINED = 'DECLINED';
    case DONE     = 'DONE';
    case CANCEL   = 'CANCEL';
}
