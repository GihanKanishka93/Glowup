<?php

namespace App\DataTables;

use App\Models\Bill;
use App\Models\Treatment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

class BillingReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('id', function ($item) {
                $url = route('billing.show', $item->id);

                return '<a href="' . $url . '">' . $item->billing_id . '</a>';
            })
            ->addColumn('patient_name', function ($item) {
                return $item->treatment->patient->name ?? 'N/A';
            })
            ->addColumn('doctor_name', function ($item) {
                return $item->treatment->doctor->name ?? 'N/A';
            })
            ->addColumn('billing_date', function ($item) {
                return $item->billing_date ?? 'N/A';
            })
            ->addColumn('total', function ($item) {
                return $item->total ?? 'N/A';
            })
            ->addColumn('action', function ($item) {
                $user = auth()->user();
                $btn = '';

                $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('billing.show', $item->id) . '" data-bs-toggle="tooltip" title="View Bill Details">'
                    . '<i class="fa fa-file"></i>'
                    . '</a> ';


                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['id', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Bill $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['treatment.patient', 'treatment.doctor'])
            ->select('bills.*')
            ->whereBetween('bills.billing_date', [
                Carbon::parse($this->start_date)->startOfDay(),
                Carbon::parse($this->end_date)->endOfDay(),
            ]);
        // if ($this->patient_id != '') {
        //     $query->where('bills.patient_id', '=', $this->patient_id);
        // }
        // if ($this->room_id != '') {
        //     $query->where('bills.room_id', '=', $this->room_id);
        // }

        // if ($this->district_id != '') {
        //     $district_id = $this->district_id;
        //     $query->whereHas('patient.address', function ($q) use ($district_id) {
        //         $q->where('district_id', $district_id);
        //     });
        // }

        return $query;
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
            Column::make('billing_id')->title('Billing ID')->orderable(true)->searchable(true),
            Column::make('patient_name')->title('Client Name')->orderable(true)->searchable(true),
            Column::make('doctor_name')->title('Doctor Name')->orderable(true)->searchable(true),
            Column::make('billing_date')->title('Billing Date')->orderable(true)->searchable(true),
            Column::make('total')->title('Bill Amount')->orderable(true)->searchable(true),
            Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(230)
                ->addClass('text-center'),
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
