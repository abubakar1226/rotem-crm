<?php

namespace App\DatatableSchemas;

class AppointmentsSchema implements DatatableSchema
{
    const TABLE_NAME = 'appointments';
    const DISPLAY_NAME = 'Appointments';
    const DESCRIPTION = 'Table to manage all appointments in one place';

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
                'title' => 'Technician',
                'name' => 'technician',
                'position' => 8
            ],
            [
                'searchable' => false,
                'title' => 'Appointment Date',
                'name' => 'appointment_date',
                'position' => 9
            ],
            [
                'searchable' => false,
                'title' => 'Appointment Window',
                'name' => 'appointment_window',
                'position' => 10
            ],
            [
                'title' => 'Job Description',
                'name' => 'job_description',
                'position' => 11
            ],
        ];
    }
}
