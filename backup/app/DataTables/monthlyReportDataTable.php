<?php

namespace App\DataTables;

use App\Models\occupancy;
use App\Models\monthlyReport;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class monthlyReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->editColumn('distinct_count',function($item){
            return '<div class="text-right  p-1 m-1 pr-2">'.$item->distinct_count.'</div>';
        })
        ->editColumn('p_count',function($item){
            return '<div class="bg-success text-right text-white p-1 m-1 pr-2">'.$item->p_count.'</div>';
        })
        ->editColumn('m_count',function($item){
            return '<div class="bg-danger text-right text-white p-1 m-1 pr-2">'.$item->m_count.'</div>';
        })
        ->editColumn('f_count',function($item){
            return '<div class="bg-info text-right text-white p-1 m-1 pr-2">'.$item->f_count.'</div>';
        })
        ->editColumn('o_count',function($item){
            return '<div class="bg-warning text-right text-white p-1 m-1 pr-2">'.$item->o_count.'</div>';
        })
        ->editColumn('count',function($item){
            return '<div class="font-weight-bold text-right p-1 m-1 pr-2">'.$item->count.'</div>';
        })
        ->rawColumns(['distinct_count', 'p_count','m_count','f_count','o_count','count']);
         //   ->addColumn('action', 'monthlyreport.action');
          //  ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(occupancy $model): QueryBuilder
    {
       // return $model->newQuery();
     return $model->select(
        DB::raw('COUNT(*) as count'),
        DB::raw('COUNT(DISTINCT admission_id) as distinct_count'),
        DB::raw('CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0")) as month_year'),
        DB::raw('SUM(CASE WHEN type = "p" THEN 1 ELSE 0 END) as p_count'),
        DB::raw('SUM(CASE WHEN type = "f" THEN 1 ELSE 0 END) as f_count'),
        DB::raw('SUM(CASE WHEN type = "m" THEN 1 ELSE 0 END) as m_count'),
        DB::raw('SUM(CASE WHEN type IN ("o", "g") THEN 1 ELSE 0 END) as o_count')
    )
    ->groupBy('month_year');
  //  ->orderBy('month_year','desc')
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('monthlyreport-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    
                 //   ->selectStyleSingle()
                    ->buttons([
                   //     Button::make('excel'),
                     //   Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                       // Button::make('reset'),
                       // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
          
             Column::make('month_year')->title('Month')->searchable(false),
             Column::make('distinct_count')->title('Number of beneficiaries served')->searchable(false),
             Column::make('p_count')->title('Childrens')->searchable(false),
             Column::make('m_count')->title('Mothers')->searchable(false),
             Column::make('f_count')->title('Fathers')->searchable(false),
             Column::make('o_count')->title('Others')->searchable(false),
             Column::make('count')->title('Number of bed nights provided')->searchable(false),
            // Column::make('add your columns'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'monthlyReport_' . date('YmdHis');
    }
}
