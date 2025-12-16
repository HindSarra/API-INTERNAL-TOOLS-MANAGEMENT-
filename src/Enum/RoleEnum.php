<?php
namespace App\Enum;

enum RoleEnum: string {
    case Employee = 'employee';
    case Manager = 'manager';
    case Admin = 'admin';
}
