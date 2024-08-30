<?php

namespace App\Enum;

enum RoleEnum: string
{
    case SUPERADMINISTRATOR = "Super Administrator";
    case ADMINISTRATOR = "Administrator";
    case USER = "User";
}
