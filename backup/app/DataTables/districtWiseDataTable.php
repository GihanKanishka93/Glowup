<?php

namespace App\DataTables;

use App\Models\district;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class districtWiseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            //  ->addColumn('action', 'districtwise.action')
            ->addIndexColumn()
            // ->addColumn('province', function ($item) {
            //     //return $item->address->count();
            //     return $item->province->name_en;
            // })
            ->addColumn('count', function ($item) {
                return $item->address->count();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(district $model): QueryBuilder
    {
     //   return $model->newQuery()->select('districts.*','province.name_en')->with('province');
     return $model->newQuery()
     ->select('districts.*')
   //  ->addSelect('provinces.name_en')
     ->with('province');
   //  ->leftJoin('provinces', 'provinces.id', '=', 'districts.province_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $defaultSearch = $this->defaultSearch ?? '';
        return $this->builder()
            ->setTableId('districtwise-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->search(['value' => $defaultSearch])
            ->orderBy(4)
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
            Column::make('id')->visible(false),
            Column::make('name_en')->title('District'),
            Column::make('province.name_en')->data('province.name_en')->title('Province')->searchable(true),
          //  Column::make('province.name_en')->visible(false)->searchable(true),
            Column::make('count')->orderable(false), 
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'districtWise_' . date('YmdHis');
    }
}