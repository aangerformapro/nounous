<?php

namespace Models;

enum UserType: string
{
    case PARENT     = 'PARENT';
    case BABYSITTER = 'BABYSITTER';
}
