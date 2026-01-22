<?php

namespace App\DataTables;

use App\Models\room;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class roomDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
 
        ->addColumn('floor_number',function($item){
            return '<span class="badge badge-danger badge-counter">'.(($item->floor->number)??'').'</span>';
        }) 
        ->addColumn('name_link', function ($item) {
            return '<a href="' . route('room.show', $item->id) . '">' . $item->room_number . '</a>';
        })
        ->addColumn('action', function($item){
            $user = Auth()->user(); 
            $btn = '';
            if($user->can('room-edit')){
            $btn .= '<a class="btn btn-circle btn-sm btn-info" data-bs-toggle="tooltip" title="Edit" href="'.route('room.edit',$item->id).'"><i class="fa fa-pen"></i></a> ';
          //  $btn .=  '<a href="'.route('room.show',$item->id).'" class="btn btn-circle btn-sm btn-warning"  data-toggle="tooltip" title="Show" ><i class="fa fa-eye"></i></a>';
            }
     if($user->can('room-delete')){
        if($item->status!=20){ 
        $btn .=  '<button class="btn btn-danger btn-circle btn-sm delete-btn" data-bs-toggle="tooltip" title="Delete" data-id="'.$item->id.'"> <i class="fa fa-trash-alt"></i></button>';
            $btn .= '<form  action="'. route('room.destroy',$item->id).'" method="POST" class="d-inline"  id="del'.$item->id.'" >
           '.csrf_field().' '.method_field("DELETE").' <button type="submit"  class="btn btn-circle btn-sm btn-danger d-none"   
           onclick="return confirm(\'Do you need to delete this ? \');"> 
           <i class="fa fa-trash-alt"></i></button>  

           </form>';
                    } else {
                        $btn .= '<button disabled class="btn btn-danger btn-circle btn-sm disabled cursor-not-allowed"  > <i class="fa fa-trash-alt"></i></button>';
                    }
                }
                return $btn;
            })
            ->addColumn('status', function ($item) {
                switch ($item->status) {
                    case 1:
                        $st = '<span class="badge badge-success badge-counter">Available (Inventory Complete)</span>';
                        break;
                    case 2:
                        $st = '<span class="badge badge-warning">Available (Inventory Incomplete)</span>';
                        break;
                    case 20:
                        $st = '<span class="badge badge-info badge-counter">Occupied</span>';
                        break;
                    case 30:
                        $st = '<span class="badge badge-danger badge-counter">Under Maintenance</span>';
                        break;
                    default:
                        $st = '<span class="badge badge-warning badge-counter">N/A</span>';
                        break;
                }
                return $st;
            })
            ->addIndexColumn()
            ->setRowId('id')
            ->rawColumns(['action', 'room_number','name_link', 'floor_number', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(room $model): QueryBuilder
    {
        return $model->newQuery()->with('floor');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('room-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(2, 'asc')
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
                        'searchPlaceholder' => 'Search by Room Number',
                    ],
                ]);
        ;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
 
            Column::make('floor_id')->visible(false),
            Column::make('name_link')->title('Rooms'),
            Column::make('room_number')->searchable(true)->visible(false),
            Column::make('floor_number')->title('floor')->orderable(false),
            Column::make('status')->orderable(false),
            Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(160)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Room_' . date('YmdHis');
    }
}