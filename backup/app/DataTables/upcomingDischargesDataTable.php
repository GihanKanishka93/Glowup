<?php

namespace App\DataTables;

use App\Models\admission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class upcomingDischargesDataTable extends DataTable
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
            ->addColumn('patient_name', function ($item) {
                return '<a href="' . route('patient.show', $item->patient->id) . '"  target="_blank">' . $item->patient->patient_id . ' - ' . $item->patient->name . '</a>';
            })
            ->filterColumn('patient_name', function ($query, $keyword) {
                $query->whereHas('patient', function ($query) use ($keyword) {
                    $query->where('patient_id', 'like', "%$keyword%")
                        ->orWhere('name', 'like', "%$keyword%");
                });
            })
            ->addColumn('id', function ($item) {

                return '<a href="' . route('admission.show', ['id' => $item->id, 'type' => 'current']) . '"  target="_blank">' . $item->id . '</a>';

            })
            ->setRowId('id')
            ->rawColumns(['patient_name', 'id']); // Add 'id' to rawColumns
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(admission $model): QueryBuilder
    {

        $searchValue = request()->input('search.value');
        $orderByColumnIndex = request()->input('order.0.column');
        $orderByDirection = request()->input('order.0.dir');


        $query = $model->select('admissions.*')
            ->whereBetween('plan_to_check_out', [$this->from_date, $this->to_date])
            ->whereNull('date_of_check_out')
            ->with('patient')
            ->when($searchValue, function ($query) use ($searchValue) {
                $query->Where(function ($query) use ($searchValue) {
                    // Search for Patient ID or Name separately
                    $query->whereHas('patient', function ($query) use ($searchValue) {
                        $query->where('patient_id', 'like', '%' . $searchValue . '%')
                            ->orWhere('name', 'like', '%' . $searchValue . '%');
                    });
                })
                    ->orWhereHas('patient', function ($query) use ($searchValue) {
                        // Search for a combination of Patient ID and Name
                        $query->whereRaw("CONCAT(patient_id, ' ', name, ' ', father_contact) like ?", ['%' . $searchValue . '%']);
                    })
                    ->orWhere('admissions.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('date_of_check_in', 'like', '%' . $searchValue)
                    ->orWhere('plan_to_check_out', 'like', '%' . $searchValue . '%');
            })
            ->when($orderByColumnIndex !== null, function ($query) use ($orderByColumnIndex, $orderByDirection) {
                if ($orderByColumnIndex == 1) {
                    // Sort by Admission ID
                    $query->orderBy('patient_id', $orderByDirection);
                } elseif ($orderByColumnIndex == 2) {
                    // Sort by Patient ID
                    $query->orderBy('id', $orderByDirection);
                } elseif ($orderByColumnIndex == 3) {
                    // Sort by Check In
                    $query->orderBy('date_of_check_in', $orderByDirection);
                } elseif ($orderByColumnIndex == 4) {
                    // Sort by Check Out
                    $query->orderBy('plan_to_check_out', $orderByDirection);
                }
            });

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->searchPanes(SearchPane::make())
            ->setTableId('upcomingdischarges-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('pdf')->extend('pdf')
                    ->filename('upcoming_discharges_' . date('YmdHis'))
                    ->orientation('landscape') // Adjust orientation if needed
                    ->pageSize('A4'), // Adjust page size if needed
                Button::make('print'),
                Button::make('reset'),
            ]);
    }


    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::computed('patient_name')
                ->title('Patient ID & Name')
                ->data('patient_name')
                ->orderable(true)
                ->searchable(true),
            Column::make('id')->data('id')->title('Admissions No'),
            Column::make('date_of_check_in')->title('Check in Date'),
            Column::make('plan_to_check_out')->title('Planned Check Out Date'),
            Column::make('patient.father_contact')->data('patient.father_contact')->title('Patient Contact No')->searchable(true),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'upcomingDischarges_' . date('YmdHis');
    }


}
