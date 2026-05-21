<?php

namespace App\Enums;

enum NotificationAudienceType: string
{
    case AllCustomers = 'all_customers';
    case AllArtisans = 'all_artisans';
    case SingleUser = 'single_user';
}
