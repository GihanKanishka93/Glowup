<?php

namespace App\DataTables;

use App\Models\Bill;
use App\Models\Treatment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class monthlyReportDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('id', function ($item) {
                $url = route('billing.show', $item->id);

                return '<a href="' . $url . '">' . $item->billing_id . '</a>';
            })
            ->addColumn('pet_name', function ($item) {
                return $item->treatment->pet->name ?? 'N/A';
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

    public function query(Bill $model): QueryBuilder
    {
        $searchValue = request()->input('search.value');
        $orderByColumnIndex = request()->input('order.0.column');
        $orderByDirection = request()->input('order.0.dir');
        $selectedDoctorId = request()->input('doctor_id');
        $selectedPetId = request()->input('pet_id');
        $startDateInput = request()->input('start_date');
        $endDateInput = request()->input('end_date');

        $currentMonthStart = $startDateInput ? Carbon::parse($startDateInput)->startOfDay() : Carbon::now()->startOfMonth();
        $currentMonthEnd = $endDateInput ? Carbon::parse($endDateInput)->endOfDay() : Carbon::now()->endOfMonth();

        // Start with the base query and include necessary relationships
        $query = $model->newQuery()
            ->with([
                'treatment.pet',
                'treatment.doctor',
            ])
            ->whereBetween('bills.billing_date', [$currentMonthStart, $currentMonthEnd])
            ->whereNull('bills.deleted_at'); // Exclude soft-deleted records

        if (!empty($selectedDoctorId)) {
            $query->whereHas('treatment.doctor', function ($q) use ($selectedDoctorId) {
                $q->where('doctors.id', $selectedDoctorId)
                    ->whereNull('doctors.deleted_at');
            });
        }

        if (!empty($selectedPetId)) {
            $query->whereHas('treatment.pet', function ($q) use ($selectedPetId) {
                $q->where('pets.id', $selectedPetId)
                    ->whereNull('pets.deleted_at');
            });
        }

        // Apply search filter if a search value is provided
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('treatment.pet', function ($q) use ($searchValue) {
                    $q->where('name', 'like', '%' . $searchValue . '%')
                        ->whereNull('pets.deleted_at'); // Exclude soft-deleted pets
                })
                    ->orWhereHas('treatment.doctor', function ($q) use ($searchValue) {
                        $q->where('name', 'like', '%' . $searchValue . '%')
                            ->whereNull('doctors.deleted_at'); // Exclude soft-deleted doctors
                    })
                    ->orWhere('bills.billing_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('bills.billing_date', 'like', '%' . $searchValue . '%');
            });
        }

        // Apply ordering if a column index and direction are provided
        if ($orderByColumnIndex !== null) {
            switch ($orderByColumnIndex) {
                case 1:
                    $query->orderBy('bills.billing_date', $orderByDirection);
                    break;
                case 2:
                    $query->orderBy(Treatment::select('pets.name')
                        ->join('pets', 'pets.id', '=', 'treatments.pet_id')
                        ->whereNull('pets.deleted_at') // Exclude soft-deleted pets
                        ->whereColumn('treatments.id', 'bills.treatment_id'), $orderByDirection);
                    break;
                case 3:
                    $query->orderBy(Treatment::select('doctors.name')
                        ->join('doctors', 'doctors.id', '=', 'treatments.doctor_id')
                        ->whereNull('doctors.deleted_at') // Exclude soft-deleted doctors
                        ->whereColumn('treatments.id', 'bills.treatment_id'), $orderByDirection);
                    break;
            }
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('billing-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', "data.start_date = $('#start_date').val(); data.end_date = $('#end_date').val(); data.doctor_id = $('#doctor_id').val(); data.pet_id = $('#pet_id').val();")
            ->orderBy(1, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->parameters([
                'language' => [
                    'search' => '',
                    'searchPlaceholder' => 'Search...',
                ],
                'order' => [
                    [1, 'desc']
                ],
                'pageLength' => 10,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('billing_id')->title('Billing ID')->orderable(true)->searchable(true),
            Column::make('pet_name')->title('Client Name')->orderable(true)->searchable(true),
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
        return 'monthlyReport_' . date('YmdHis');
    }
}
