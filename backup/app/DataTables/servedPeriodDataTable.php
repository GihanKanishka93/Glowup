<?php

namespace App\DataTables;

use App\Models\admission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\EloquentDataTable; 
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

class servedPeriodDataTable extends DataTable
{ 
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('district', function ($item) {
                return $item->patient->address->district->name_en;
            })
            ->addColumn('date_of_check_out',function($item){
                return ($item->date_of_check_out)??'Pending..';
            })
            ->filterColumn('patient_name', function ($query, $keyword) {
                $query->whereHas('patient', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%");
                });
            })
            ->filterColumn('district', function ($query, $keyword) {
                $query->whereHas('patient.address.district', function ($query) use ($keyword) {
                    $query->where('name_en', 'like', "%$keyword%");
                });
            })
            ->setRowId('id')
            ->rawColumns(['district']);
        // return (new EloquentDataTable($query))
        // ->addIndexColumn()
        // ->addColumn('district',function($item){
        //     return $item->patient->address->district->name_en;
        // })
        //     ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(admission $model): QueryBuilder
    {

        $query = $model->select('admissions.*')
            ->whereBetween('admissions.date_of_check_in', [$this->start_date, Carbon::parse($this->end_date)->addDay()]);
        if ($this->patient_id != '') {
            $query->where('admissions.patient_id', '=', $this->patient_id);
        }
        if ($this->room_id != '') {
            $query->where('admissions.room_id', '=', $this->room_id);
        }

        if ($this->district_id != '') {
            $district_id = $this->district_id;
            $query->whereHas('patient.address', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }

        return $query->with('room', 'patient');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        
        return $this->builder()
            ->searchPanes(SearchPane::make())
            ->setTableId('servedperiod-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                //    Button::make('excel'),
                //     Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                //    Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('id')->title('Admission No'),
            Column::make('patient.id')->title('Patient ID')->visible(false),
            Column::make('patient.name')->data('patient.name')->title('Patient'),
            Column::make('district')->searchPanes(true),
            Column::make('room.room_number')->date('room.room_number')->title('Room'),
            Column::make('date_of_check_in')->title('Check In'),
            Column::make('date_of_check_out')->title('Check Out'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'servedPeriod_' . date('YmdHis');
    }
}