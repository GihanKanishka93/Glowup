<?php

namespace App\DataTables;

use App\Models\user;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class suspendUsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('roles',function($item){
            $res = '';
            foreach($item->getRoleNames() as $v){ 
                    $res .= '<label class="badge badge-success">'.$v.' </label>';
                    };
                    return $res;
        })
        ->addColumn('name',function($item){
            return $item->designation.' '.$item->first_name.' '.$item->last_name;
        })
        ->addColumn('action', function($item){
            $btn =  '<a href="'.route('users.activate',$item->id).'" class="btn btn-sm btn-primary btn-circle " onclick="return confirm(\'Do you need to activate this User\');"  data-bs-toggle="tooltip" title="Reactivate User"><i class="fa fa-undo"></i></a>';

            return $btn; 
        })
            ->addIndexColumn()
            ->rawColumns(['roles','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(user $model): QueryBuilder
    {
        return $model->onlyTrashed()->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('suspendusers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])->parameters([
                        'language' => [
                            'search' => '', 
                            'searchPlaceholder' => 'Search...',
                        ],
                    ]);;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('user_name'),
            Column::make('name')->orderable(false),
            Column::make('email'),
            COlumn::make('contact_number')->title('Mobile'),
            Column::make('roles'),
            Column::computed('action')
            ->title('')
            ->exportable(false)
            ->printable(false)
            ->width(150)
            ->addClass('text-center'),
            Column::make('first_name')->hidden(true)->searchable(true),
            Column::make('last_name')->hidden(false)->searchable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'suspendUsers_' . date('YmdHis');
    }
}
