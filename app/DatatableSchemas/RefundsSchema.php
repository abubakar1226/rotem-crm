<?php

namespace App\DatatableSchemas;

class RefundsSchema implements DatatableSchema
{
    const TABLE_NAME = 'refunds';
    const DISPLAY_NAME = 'Refunds';
    const DESCRIPTION = 'Table to manage all refunds in one place';

    public static function table(): array
    {
        return [
            'table_name' => self::TABLE_NAME,
            'display_name' => self::DISPLAY_NAME,
            'description' => self::DESCRIPTION,
        ];
    }

    public static function columns(): array
    {
        return [
            [
                'searchable' => false,
                'title' => 'ID',
                'name' => 'id',
                'position' => 1
            ],
            [
                'title' => 'Name',
                'name' => 'name',
                'position' => 2
            ],
            [
                'title' => 'Phone Number',
                'name' => 'phone_number',
                'position' => 3
            ],
            [
                'title' => 'Address',
                'name' => 'address',
                'position' => 4
            ],
            [
                'title' => 'State',
                'name' => 'state',
                'position' => 4
            ],
            [
                'title' => 'City',
                'name' => 'city',
                'position' => 4
            ],
            [
                'title' => 'Zip Code',
                'name' => 'post_code',
                'position' => 4
            ],
            [
                'title' => 'Refund Status',
                'name' => 'status',
                'position' => 5
            ],
            [
                'title' => 'Lead Status',
                'name' => 'lead_status',
                'position' => 5
            ],
            [
                'title' => 'Platform',
                'name' => 'platform',
                'position' => 6
            ],
            [
                'searchable' => false,
                'title' => 'Price',
                'name' => 'price',
                'position' => 7
            ],
            [
                'searchable' => false,
                'title' => 'Updated At',
                'name' => 'updated_at',
                'position' => 8
            ],
            [
                'searchable' => false,
                'title' => 'Created At',
                'name' => 'created_at',
                'position' => 9
            ],
        ];
    }
}
