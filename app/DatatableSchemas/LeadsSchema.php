<?php

namespace App\DatatableSchemas;

class LeadsSchema implements DatatableSchema
{
    const TABLE_NAME = 'leads';
    const DISPLAY_NAME = 'Leads';
    const DESCRIPTION = 'Table to manage all leads in one place';

    public static function table(): array
    {
        return [
            'table_name' => static::TABLE_NAME,
            'display_name' => static::DISPLAY_NAME,
            'description' => static::DESCRIPTION,
            'include_action_buttons' => true,
            'fixedColumnsEnd' => 1,
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
                'title' => 'City',
                'name' => 'city',
                'position' => 5
            ],
            [
                'title' => 'State',
                'name' => 'state',
                'position' => 6
            ],
            [
                'title' => 'Zip Code',
                'name' => 'post_code',
                'position' => 7
            ],
            [
                'title' => 'Status',
                'name' => 'status',
                'position' => 8
            ],
            [
                'title' => 'Platform',
                'name' => 'platform',
                'position' => 9
            ],
            [
                'searchable' => false,
                'title' => 'Price',
                'name' => 'price',
                'position' => 10
            ],
            [
                'searchable' => false,
                'title' => 'Updated At',
                'name' => 'updated_at',
                'position' => 11
            ],
            [
                'searchable' => false,
                'title' => 'Created At',
                'name' => 'created_at',
                'position' => 12
            ],
        ];
    }
}
