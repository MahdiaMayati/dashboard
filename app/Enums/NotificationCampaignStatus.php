<?php

namespace App\Enums;

enum NotificationCampaignStatus: string
{
    case Draft = 'draft';
    case Queued = 'queued';
    case Sending = 'sending';
    case Completed = 'completed';
    case Failed = 'failed';
}
