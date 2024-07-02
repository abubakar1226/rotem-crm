<?php

namespace App\DatatableSchemas;

class TechniciansSchema implements DatatableSchema
{
    const TABLE_NAME = 'technicians';
    const DISPLAY_NAME = 'Technicians';
    const DESCRIPTION = 'Table to manage all technicians data in one place';

    public static function table(): array
    {
        return [
            'table_name' => self::TABLE_NAME,
            'display_name' => self::DISPLAY_NAME,
            'description' => self::DESCRIPTION,
            'include_action_buttons' => true,
            'fixedColumnsEnd' => 1,
        ];
    }

    public static function columns(): array
    {
        return [
            [
                'searchable' => false,
                'title' => 'Id',
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
                'title' => 'Email',
                'name' => 'email',
                'position' => 4
            ],
            [
                'searchable' => false,
                'title' => 'Created At',
                'name' => 'created_at',
                'position' => 5
            ],
            [
                'searchable' => false,
                'title' => 'Updated At',
                'name' => 'updated_at',
                'position' => 6
            ],
        ];
    }
}
