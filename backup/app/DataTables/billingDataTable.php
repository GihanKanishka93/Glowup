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

class BillingDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('id', function ($item) {
                return '<a href="">' . $item->billing_id . '</a>';
            })
            ->addColumn('pet_name', function ($item) {
                return $item->treatment->pet->name ?? 'N/A';
            })
            ->addColumn('doctor_name', function ($item) {
                return $item->treatment->doctor->name ?? 'N/A';
            })
            ->addColumn('action', function ($item) {
                $user = auth()->user();
                $btn = '';

                if ($user->can('bill-edit')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('billing.edit', $item->id) . '" data-bs-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a> ';
                }
                if ($user->can('bill-print')) {
                    $btn .= '<a class="btn bg-success text-white btn-circle btn-sm" href="' . route('billing.print', ['id' => $item->id]) . '" target="_blank" data-bs-toggle="tooltip" title="Print Bill"><i class="fa fa-solid fa-print"></i></a>';
                }
                if ($user->can('bill-print')) {
                    $btn .= '<a class="btn text-white  btn-sm" href="' . route('billing.print-prescription', ['id' => $item->id]) . '" target="_blank" data-bs-toggle="tooltip" title="Print Prescription"><i title="Print Prescription" class="fa-solid fa-message-smile fa-2xl" style="color: #B197FC;"></i></a>&nbsp;';
                }
                if ($user->can('bill-delete')) {
                    // if ($item->admissions()->whereNull('date_of_check_out')->count() == 0) {
                    $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm" data-id="' . $item->id . '"><i class="fa fa-trash-alt"></i></button>';
                    $btn .= '<form action="' . route('billing.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">'
                        . csrf_field() . ' ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" title="Delete"></button>
                                </form>';
                 }
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

        // Start with the base query and include necessary relationships
        $query = $model->newQuery()
            ->with([
                'treatment.pet',
                'treatment.doctor',
            ])
            ->whereNull('deleted_at'); // Exclude soft-deleted records

        // Apply search filter if a search value is provided
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('treatment.pet', function ($q) use ($searchValue) {
                    $q->where('name', 'like', '%' . $searchValue . '%')
                        ->whereNull('deleted_at'); // Exclude soft-deleted pets
                })
                    ->orWhereHas('treatment.doctor', function ($q) use ($searchValue) {
                        $q->where('name', 'like', '%' . $searchValue . '%')
                            ->whereNull('deleted_at'); // Exclude soft-deleted doctors
                    })
                    ->orWhere('bills.billing_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('billing_date', 'like', '%' . $searchValue . '%');
            });
        }

        // Apply ordering if a column index and direction are provided
        if ($orderByColumnIndex !== null) {
            switch ($orderByColumnIndex) {
                case 1:
                    $query->orderBy('billing_id', $orderByDirection);
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
            ->minifiedAjax()
            ->orderBy(1)
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
                    [1, 'asc']
                ],
                'pageLength' => 10,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('billing_id')->title('Billing ID')->orderable(true)->searchable(true),
            Column::make('pet_name')->title('Pet Name')->orderable(true)->searchable(true),
            Column::make('doctor_name')->title('Doctor Name')->orderable(true)->searchable(true),
            Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(230)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'billing_' . date('YmdHis');
    }
}
