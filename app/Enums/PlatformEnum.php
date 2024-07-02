<?php

namespace App\Enums;

/**
 * @method static self yelp()
 * @method static self thumbtack()
 * @method static self networx()
 * @method static self angiLeads()
 * @method static self facebookAds()
 * @method static self googleAds()
 * @method static self websiteLeads()
 */
class PlatformEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'yelp' => 'Yelp',
            'thumbtack' => 'Thumbtack',
            'networx' => 'Networx',
            'angiLeads' => 'Angi Leads / Homeadvisor',
            'facebookAds' => 'Facebook ads',
            'googleAds' => 'Google Ads / Gmb’s',
            'websiteLeads' => 'Website Leads',
        ];
    }
}
