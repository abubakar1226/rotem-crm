<?php

namespace App\DatatableSchemas;

class SubReportsSchema implements DatatableSchema
{
    const TABLE_NAME = 'sub_reports';
    const DISPLAY_NAME = 'Appointment Sub Reports ';
    const DESCRIPTION = 'Table to manage all appointment reports in one place';

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
                'title' => 'Job Total',
                'name' => 'job_total',
                'position' => 1
            ],
            [
                'title' => 'Name',
                'name' => 'name',
                'position' => 2
            ],
            [
                'title' => 'Date',
                'name' => 'date',
                'position' => 3
            ],
            [
                'title' => 'Closing',
                'name' => 'closing',
                'position' => 4
            ],
            [
                'title' => 'Address',
                'name' => 'address',
                'position' => 5
            ],
            [
                'title' => 'City',
                'name' => 'city',
                'position' => 6
            ],
            [
                'title' => 'State',
                'name' => 'state',
                'position' => 7
            ],
            [
                'title' => 'Zip Code',
                'name' => 'post_code',
                'position' => 8
            ],
            [
                'title' => 'Technician',
                'name' => 'technician',
                'position' => 9
            ],
            [
                'title' => 'Payment Method',
                'name' => 'payment_method',
                'position' => 10
            ],
            [
                'title' => 'Technician\'s Materials',
                'name' => 'technician_materials_cost',
                'position' => 11
            ],
            [
                'title' => 'Company\'s Materials',
                'name' => 'company_materials_cost',
                'position' => 12
            ],
            [
                'title' => 'Technician\'s Profit',
                'name' => 'technician_profit',
                'position' => 13
            ],
            [
                'title' => 'Technician\'s Balance',
                'name' => 'technician_balance',
                'position' => 14
            ],
            [
                'title' => 'Company\'s Balance',
                'name' => 'company_balance',
                'position' => 15
            ],
        ];
    }
}
