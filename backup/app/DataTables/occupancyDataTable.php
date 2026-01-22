<?php

namespace App\DataTables;

use App\Models\occupancy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class occupancyDataTable extends DataTable
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
                if($user->can('past-room-occupancy-edit')){
                $btn .= '<a class="btn btn-circle btn-sm btn-info"  data-bs-toggle="tooltip" title="Edit" href="'.route('occupancy.edit',$item->id).'"><i class="fa fa-pen"></i></a> ';
          //      $btn .=  '<a href="'.route('item.show',$item->id).'" class="btn btn-circle btn-sm btn-warning"  data-toggle="tooltip" title="Show" ><i class="fa fa-eye"></i></a>';
                }
                $btn .= '<a class="btn btn-warning  btn-circle btn-sm" data-bs-toggle="tooltip" title="View/Mark" href="'.route('occupancy.show',$item->id).'"><i class="fa fa-eye"></i></a>';
               
                if ($user->can('room-occupancy-delete')) {
                    
                        $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm " data-id="' . $item->id . '"> <i class="fa fa-trash-alt"></i></button>';
                        $btn .= '<form  action="' . route('occupancy.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">
           ' . csrf_field() . ' ' . method_field("DELETE") . ' <button type="submit"  class="btn btn-danger btn-circle btn-sm d-none"   
            title="Delete">
           </form>';
                    } 
                return $btn;
            })
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(occupancy $model): QueryBuilder
    {
        return $model->newQuery()
        ->selectRaw('DATE(date) as date, COUNT(*) as total, MIN(id) as id')
        ->groupBy('date');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('occupancy-table')
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
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false), 
            Column::make('date'),
           Column::make('total'),
           Column::computed('action')
           ->exportable(false)
           ->printable(false)
           ->width(160)
           ->addClass('text-center'),
         //   Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'occupancy_' . date('YmdHis');
    }
}
