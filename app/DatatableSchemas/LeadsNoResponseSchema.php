<?php

namespace App\DatatableSchemas;

class LeadsNoResponseSchema extends LeadsSchema
{
    const TABLE_NAME = 'leads_no_response';
    const DISPLAY_NAME = 'Leads (No Response)';
    const DESCRIPTION = 'Table to manage all leads with status "No Response" in one place';

    public static function columns(): array
    {
        $columns =  [];
        foreach (parent::columns() as $i => $column) {
            $columns[] = $column;
            if ($column['name'] === 'status') {
                $columns[] = [
                    'searchable' => false,
                    'title' => 'Follow Up In',
                    'name' => 'follow_up_at',
                    'position' => count($columns) + 1,
                ];
            }
        }

        return $columns;
    }
}
