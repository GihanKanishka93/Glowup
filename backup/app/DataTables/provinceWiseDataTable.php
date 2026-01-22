<?php

namespace App\DataTables;

use App\Models\province;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class provinceWiseDataTable extends DataTable
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
            ->addColumn('count', function ($item) {
                //return $item->district->count();
                $addressCount = 0;
                foreach ($item->district as $districtItem) {
                    $addressCount += $districtItem->address->count();
                };
                return $addressCount;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(province $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $defaultSearch = $this->defaultSearch ?? '';
        return $this->builder()
            ->setTableId('provincewise-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->search(['value' => $defaultSearch])
            ->orderBy(3)
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
            Column::make('name_en')->title('Province'),
            Column::make('count')->orderable(false),
            //  Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'provinceWise_' . date('YmdHis');
    }
}