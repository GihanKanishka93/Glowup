<?php

namespace App\DataTables;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class roleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($item){
            $user = Auth()->user(); 
            $btn = '';
            if($user->can('role-edit')){
            $btn .= '<a class="btn btn-info  btn-circle btn-sm" href="'.route('role.edit',$item->id).'" data-bs-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a> ';
            }
            if($user->can('role-delete')){
                $btn .=  '<button class="btn btn-danger delete-btn btn-circle btn-sm " data-bs-toggle="tooltip" title="Delete" data-id="'.$item->id.'"> <i class="fa fa-trash-alt"></i></button>';
           $btn .= '<form  action="'. route('role.destroy',$item->id).'" method="POST" class="d-inline"  id="del'.$item->id.'" >
           '.csrf_field().' '.method_field("DELETE").' <button type="submit"  class="btn btn-danger btn-circle btn-sm d-none"   
           onclick="return confirm(\'Do you need to delete this ? \');" title="Delete"> 
           <i class="fa fa-trash-alt"></i></button>  
           </form>';
            }
           return $btn;
       })
            ->addColumn('number_of_users',function($item){
                return '<span class="badge bg-primary">'.$item->users->count().'</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['action','number_of_users'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
            //        ->dom('Bfrtip')
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
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('number_of_users'),
            Column::computed('action')
            ->title('')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->orderable(false)
                  ->width(60)
                  ->addClass('text-center'), 
       //     Column::make('display_name'), 
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'role_' . date('YmdHis');
    }
}
