<?php

namespace App\DataTables;

use App\Models\Doctor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class doctorDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
         ->addColumn('doctor_id', function ($item) {
                return $item->doctor_id;
            })
            ->addColumn('name_link', function ($item) {
                return '<a href="' . route('doctor.show', $item->id) . '">' . $item->name . '</a>';
            })
            ->addColumn('gender', function ($item) {
                return ($item->gender == 1) ? 'Male' : 'Female';
            })
            ->filterColumn('gender', function ($query, $keyword) {
                $query->whereRaw("CASE WHEN gender = 1 THEN 'Male' WHEN gender = 0 THEN 'Female' END like ?", ["%{$keyword}%"]);
            })
            ->addColumn('designation', function ($item) {
                return $item->designation;
            })
            ->addColumn('contactno', function ($item) {
                return $item->contact_no;
            })
            ->addColumn('action', function ($item) {
                $user = Auth::user();
                $btn = '';
                $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('doctor.show', $item->id) . '" data-bs-toggle="tooltip" title="View">'
                    . '<i class="fa fa-file"></i>'
                    . '</a> ';

                if ($user->can('edit-doctor')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" data-bs-toggle="tooltip" href="' . route('doctor.edit', $item->id) . '" title="Edit"><i class="fa fa-pen"></i></a> ';
                }

                if ($user->can('delete-doctor')) {
                    $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm" data-id="' . $item->id . '"><i class="fa fa-trash-alt"></i></button>';
                    $btn .= '<form action="' . route('doctor.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">'
                        . csrf_field() . ' ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" title="Delete"></button>
                            </form>';
                }
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['name_link', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Doctor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('doctor-table')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('doctor_id')->title('Doctor ID')->data('doctor_id')->searchable(true),
            Column::make('name_link')->data('name_link')->title('Name')->searchable(true),
            Column::make('address')->searchable(true),
            Column::make('gender')->searchable(true),
            Column::make('contactno')->title('Contact No')->searchable(true),
             Column::make('designation')->title('designation')->searchable(true),
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

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'doctor_' . date('YmdHis');
    }
}
