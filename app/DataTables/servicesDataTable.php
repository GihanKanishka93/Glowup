<?php

namespace App\DataTables;

use App\Models\Services;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class servicesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'services.action')
            ->addColumn('action', function ($services) {
                $user = Auth()->user();
                $btn = '';
                if ($user->can('services-edit')) {
                    $btn .= '<a class="btn btn-circle btn-sm btn-info"  data-bs-toggle="tooltip" title="Edit" href="' . route('services.edit', $services->id) . '"><i class="fa fa-pen"></i></a> ';
                    //      $btn .=  '<a href="'.route('item.show',$item->id).'" class="btn btn-circle btn-sm btn-warning"  data-toggle="tooltip" title="Show" ><i class="fa fa-eye"></i></a>';
                }
                if ($user->can('services-delete')) {
                    $btn .= '<button class="btn btn-danger btn-circle btn-sm delete-btn"  data-bs-toggle="tooltip" title="Delete" data-id="' . $services->id . '"> <i class="fa fa-trash-alt"></i></button>';
                    $btn .= '<form  action="' . route('services.destroy', $services->id) . '" method="POST" class="d-inline"  id="del' . $services->id . '" >
               ' . csrf_field() . ' ' . method_field("DELETE") . ' <button type="submit"  class="btn btn-circle btn-sm btn-danger d-none"
               onclick="return confirm(\'Do you need to delete this ? \');">
               <i class="fa fa-trash-alt"></i></button>
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
    public function query(Services $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('item-table')
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
            Column::make('name'),
            Column::make('price'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'item_' . date('YmdHis');
    }
}
