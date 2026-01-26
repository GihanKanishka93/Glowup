<?php

namespace App\DataTables;

use App\Models\Patient;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class PatientDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name_link', function ($item) {
                return '<a href="' . route('patient.show', $item->id) . '">' . $item->name . '</a>';
            })
            ->addColumn('contact', function ($item) {
                return $item->mobile_number;
            })
            ->addColumn('action', function ($item) {
                $user = auth()->user();
                $btn = '';
                $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('patient.show', $item->id) . '" data-bs-toggle="tooltip" title="View Client">'
                    . '<i class="fa fa-file"></i>'
                    . '</a> ';

                if ($user->can('patient-edit')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" data-bs-toggle="tooltip" href="' . route('patient.edit', $item->id) . '" title="Edit"><i class="fa fa-pen"></i></a> ';
                }

                if ($user->can('patient-delete')) {
                    $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm" data-id="' . $item->id . '"><i class="fa fa-trash-alt"></i></button>';
                    $btn .= '<form action="' . route('patient.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">'
                        . csrf_field() . ' ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" title="Delete"></button>
                            </form>';
                }
                return $btn;
            })
            ->addColumn('gender', function ($item) {
                return ($item->gender == 1) ? 'Male' : 'Female';
            })
            ->filterColumn('gender', function ($query, $keyword) {
                $query->whereRaw("CASE WHEN gender = 1 THEN 'Male' WHEN gender = 0 THEN 'Female' END like ?", ["%{$keyword}%"]);
            })
            ->orderColumn('gender', 'gender $1')
            ->addIndexColumn()
            ->rawColumns(['name_link', 'action'])
            ->setRowId('id');
    }

    public function query(Patient $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('patient-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy([1, 'desc'])
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])->parameters([
                    'dom' => 'Bfrtip',
                    'language' => [
                        'search' => '',
                        'searchPlaceholder' => 'Search...',
                    ],
                    'responsive' => true,
                    'autoWidth' => false,
                    'processing' => true,
                    'serverSide' => true,
                    'pagingType' => 'full_numbers',
                ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('patient_id')->visible(true)->title('Client ID')->searchable(true),
            Column::make('id')->visible(false),
            Column::make('name_link')->data('name_link')->title('Name')->searchable(true)->orderData(true),
            Column::make('name')->visible(false),
            Column::make('gender')->searchable(true),
            Column::make('contact')->title('Mobile')->searchable(true)->orderable(false),
            Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(180)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'patient_' . date('YmdHis');
    }
}
