<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Artisan = 'artisan';
    case Admin = 'admin';
    case Support = 'support';
}
