<?php

namespace App\Http\Controllers\Backend;

use App\Datatables\Datatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableFormRequest;
use App\Models\Column;
use App\Models\Table;

class TablesController extends Controller
{
    public function edit(Table $table)
    {
        return view('backend.tables.edit', [
            'table' => $table
        ]);
    }

    public function update(Table $table, TableFormRequest $request) {
        $tableAttributes = $request->validated();
        $table->update($tableAttributes);

        foreach ($request->validated('columns') as $column) {
            Column::firstWhere('id', $column['id'])->update($column);
        }

        return response()->json([
            'configs' => Datatable::configs($table->table_name),
            'status' => 'success',
            'message' => 'Table configs updated successfully'
        ]);
    }
}
