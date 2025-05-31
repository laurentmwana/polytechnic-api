<?php

namespace App\Enums;

enum RoleUserEnum: string
{
    case ADMIN = "admin";

    case STUDENT = "student";

    case DISABLE = "lock";
}
