<?php

namespace App\Enums;

enum ArtisanApprovalStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
