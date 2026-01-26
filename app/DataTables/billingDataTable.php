<?php

namespace App\DataTables;

use App\Models\Bill;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BillingDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $searchParam = request()->input('search');
        if (is_array($searchParam)) {
            $searchValue = trim((string) ($searchParam['value'] ?? ''));
        } else {
            $searchValue = trim((string) ($searchParam ?? request('search', '')));
        }

        return (new EloquentDataTable($query))
            ->filter(function ($query) use ($searchValue) {
                if (!$searchValue) {
                    return;
                }

                $query->where(function ($q) use ($searchValue) {
                    $q->whereHas('treatment.patient', function ($q) use ($searchValue) {
                        $q->where('name', 'like', '%' . $searchValue . '%')
                            ->whereNull('patients.deleted_at'); // Exclude soft-deleted patients
                    })
                        ->orWhereHas('treatment.doctor', function ($q) use ($searchValue) {
                            $q->where('name', 'like', '%' . $searchValue . '%')
                                ->whereNull('doctors.deleted_at'); // Exclude soft-deleted doctors
                        })
                        ->orWhere('bills.billing_id', 'like', '%' . $searchValue . '%')
                        ->orWhere('bills.billing_date', 'like', '%' . $searchValue . '%')
                        ->orWhereExists(function ($sub) use ($searchValue) {
                            // Match bill items or linked services by name
                            $sub->select(DB::raw(1))
                                ->from('bill_items as bi')
                                ->whereNull('bi.deleted_at')
                                ->whereColumn('bi.bill_id', 'bills.id')
                                ->where(function ($serviceQuery) use ($searchValue) {
                                $serviceQuery->where('bi.item_name', 'like', '%' . $searchValue . '%')
                                    ->orWhereExists(function ($svc) use ($searchValue) {
                                        $svc->select(DB::raw(1))
                                            ->from('services as s')
                                            ->whereNull('s.deleted_at')
                                            ->whereColumn('s.name', 'bi.item_name')
                                            ->where('s.name', 'like', '%' . $searchValue . '%');
                                    });
                            });
                        })
                        ->orWhereExists(function ($sub) use ($searchValue) {
                            // Match vaccination names tied to the treatment
                            $sub->select(DB::raw(1))
                                ->from('vaccination_infos as vi')
                                ->join('vaccinations as v', function ($join) {
                                $join->on('v.id', '=', 'vi.vaccine_id')
                                    ->whereNull('v.deleted_at');
                            })
                                ->whereNull('vi.deleted_at')
                                ->whereColumn('vi.trement_id', 'bills.treatment_id')
                                ->where('v.name', 'like', '%' . $searchValue . '%');
                        });
                });
            })
            ->addColumn('id', function ($item) {
                return '<a href="">' . $item->billing_id . '</a>';
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
            ->addColumn('status', function ($item) {
                $badges = [];

                if ($item->created_at && Carbon::parse($item->created_at)->greaterThanOrEqualTo(Carbon::now()->subMinutes(60))) {
                    $badges[] = '<span class="badge rounded-pill text-bg-info">New</span>';
                }

                if ((int) $item->print_status === 1) {
                    $badges[] = '<span class="badge rounded-pill text-bg-success">Printed</span>';
                } else {
                    $badges[] = '<span class="badge rounded-pill text-bg-warning">Ready to Print</span>';
                }

                if ((int) $item->payment_status === 1) {
                    $badges[] = '<span class="badge rounded-pill text-bg-primary">Paid</span>';
                } else {
                    $badges[] = '<span class="badge rounded-pill text-bg-danger">Unpaid</span>';
                }

                return implode(' ', $badges);
            })
            ->addColumn('action', function ($item) {
                $user = auth()->user();
                $btn = '';

                $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('billing.show', $item->id) . '" data-bs-toggle="tooltip" title="View Bill Details">'
                    . '<i class="fas fa-file-alt"></i>'
                    . '</a> ';

                if ($user->can('bill-edit')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('billing.edit', $item->id) . '" data-bs-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a> ';
                }
                if ($user->can('bill-print')) {
                    if ($item->print_status == 1) {
                        if ($user->hasRole('Cashier')) {

                        } else {
                            $btn .= '<a class="btn bg-warning text-white btn-circle btn-sm" href="' . route('billing.print', ['id' => $item->id]) . '" target="_blank" data-bs-toggle="tooltip" title="Print Bill"><i class="fas fa-print"></i></a>';
                        }
                    } else {
                        $btn .= '<a class="btn bg-success text-white btn-circle btn-sm" href="' . route('billing.print', ['id' => $item->id]) . '" target="_blank" data-bs-toggle="tooltip" title="Print Bill"><i class="fas fa-print"></i></a>';

                    }
                    // Email bill action
                    $btn .= '<form action="' . route('billing.email', $item->id) . '" method="POST" class="d-inline-block ms-1" style="margin:0;padding:0;">'
                        . csrf_field()
                        . '<button type="submit" class="btn btn-warning btn-circle btn-sm text-dark" data-bs-toggle="tooltip" title="Email Bill" style="min-width:32px;">'
                        . '<i class="fas fa-envelope"></i>'
                        . '</button>'
                        . '</form>';
                }
                if ($user->can('prescription-print')) {
                    $btn .= '<a class="btn text-white btn-sm" href="' . route('billing.print-prescription', ['id' => $item->id]) . '" target="_blank" data-bs-toggle="tooltip" title="Print Prescription"><i title="Print Prescription" class="fas fa-file-prescription" style="color: #B197FC;"></i></a>&nbsp;';
                }
                // if ($user->can('bill-edit')) {
                //     $btn .= '<a class="btn text-white btn-sm medical-history-btn" href="' . route('medical-history.show', ['id' => $item->treatment->patient_id]) . '" data-bs-toggle="tooltip" title="Medical History"><i title="Medical History" class="fa-solid fa-file fa-2xl" style="color: #B197FC;"></i></a>&nbsp;';
    
                // }
                if ($user->can('bill-delete')) {
                    // if ($item->admissions()->whereNull('date_of_check_out')->count() == 0) {
                    $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm" data-id="' . $item->id . '"><i class="fas fa-trash-alt"></i></button>';
                    $btn .= '<form action="' . route('billing.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">'
                        . csrf_field() . ' ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" title="Delete"></button>
                                </form>';
                }
                return $btn;
            })
            ->addIndexColumn()
            ->filterColumn('status', function ($query, $keyword) {
                $keyword = strtolower(trim($keyword));

                if ($keyword === '') {
                    return;
                }

                if (str_contains($keyword, 'ready')) {
                    $query->where(function ($q) {
                        $q->whereNull('print_status')
                            ->orWhere('print_status', '!=', 1);
                    });
                }

                if (str_contains($keyword, 'printed')) {
                    $query->where('print_status', 1);
                }

                if (str_contains($keyword, 'unpaid')) {
                    $query->where(function ($q) {
                        $q->whereNull('payment_status')
                            ->orWhere('payment_status', '!=', 1);
                    });
                }

                if (str_contains($keyword, 'paid') && !str_contains($keyword, 'unpaid')) {
                    $query->where('payment_status', 1);
                }

                if (str_contains($keyword, 'new')) {
                    $query->where('created_at', '>=', Carbon::now()->subMinutes(60));
                }
            })
            ->rawColumns(['id', 'status', 'action'])
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
                'treatment.patient',
                'treatment.doctor',
            ])
            ->whereNull('bills.deleted_at'); // Exclude soft-deleted records

        // Apply ordering if a column index and direction are provided
        if ($orderByColumnIndex !== null) {
            switch ($orderByColumnIndex) {
                case 1:
                    $query->orderBy('bills.billing_date', $orderByDirection);
                    break;
                case 2:
                    $query->orderBy(Treatment::select('patients.name')
                        ->join('patients', 'patients.id', '=', 'treatments.patient_id')
                        ->whereNull('patients.deleted_at') // Exclude soft-deleted patients
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
                'search' => [
                    'search' => request('search', ''),
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('billing_id')->title('Billing ID')->orderable(true)->searchable(true),
            Column::make('patient_name')->title('Patient Name')->orderable(true)->searchable(true),
            Column::make('doctor_name')->title('Doctor Name')->orderable(true)->searchable(true),
            Column::make('billing_date')->title('Billing Date')->orderable(true)->searchable(true),
            Column::make('total')->title('Bill Amount')->orderable(true)->searchable(true),
            Column::make('status')->title('Status')->orderable(false)->searchable(true),
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
