<?php

namespace App\Enums;

enum ReviewModerationStatus: string
{
    case Visible = 'visible';
    case Hidden = 'hidden';
}
