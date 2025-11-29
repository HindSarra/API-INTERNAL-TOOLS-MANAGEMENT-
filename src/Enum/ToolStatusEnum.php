<?php
namespace App\Enum;

enum ToolStatusEnum: string {
    case Active = 'active';
    case Deprecated = 'deprecated';
    case Trial = 'trial';
}
