<?php

namespace App\DataTables;

use App\Models\patient;
use App\Models\admission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class patientDataTable extends DataTable
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
            ->addColumn('age', function ($item) {
                return $this->calculateAge($item->date_of_birth);
            })
            ->addColumn('district_id', function ($item) {
                return $item->address->district->name_en;
            })
            ->addColumn('action', function ($item) {
                $user = Auth::user();
                $btn = '';
                // if ($user->can('counselor-read')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" href="' . route('visit.create', $item->id) . '" data-bs-toggle="tooltip" title="Counselor Notes">'
                        . '<i class="fa fa-notes-medical"></i>'
                        . '</a> ';
                // } 

                // Check if user can edit the patient
                if ($user->can('patient-edit')) {
                    $btn .= '<a class="btn btn-info btn-circle btn-sm" data-bs-toggle="tooltip" href="' . route('patient.edit', $item->id) . '" title="Edit"><i class="fa fa-pen"></i></a> ';
                }
            
                // Check if user can delete the patient
                if ($user->can('patient-delete')) {
                    if ($item->admissions()->whereNull('date_of_check_out')->count() == 0) {
                        $btn .= '<button data-bs-toggle="tooltip" title="Delete" class="btn btn-danger delete-btn btn-circle btn-sm" data-id="' . $item->id . '"><i class="fa fa-trash-alt"></i></button>';
                        $btn .= '<form action="' . route('patient.destroy', $item->id) . '" method="POST" class="d-inline" id="del' . $item->id . '">'
                            . csrf_field() . ' ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" title="Delete"></button>
                            </form>';
                    } else {
                        $btn .= '<button disabled data-bs-toggle="tooltip" title="Delete" class="btn btn-danger disabled btn-circle btn-sm"><i class="fa fa-trash-alt"></i></button>';
                    }
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

    protected function calculateAge($dateOfBirth)
    {
        // Calculate age using Carbon\Carbon
        $dob = Carbon::parse($dateOfBirth);
        $now = Carbon::now();
        $age = $dob->diff($now);

        // Format age as 'years' and 'months'
        $ageString = '';
        if ($age->y > 0) {
            $ageString .= $age->y . 'Y';
        } else {
            $ageString .= '0Y';
        }
        if ($age->m > 0) {
            $ageString .= ', ' . $age->m . 'M';
        } else {
            $ageString .= ', 0M';
        }

        return $ageString;
    }



    /**
     * Get the query source of dataTable.
     */
    public function query(patient $model): QueryBuilder
    {
        // return $model->newQuery()->with(['address'=>
        // function($query){
        //     $query->district;
        // }

        return $model->newQuery()->with(['address', 'address.district']);
        //  ]);

        // return  $model->select('admissions.*')->newQuery()
        // ->where('date_of_check_out', '=', null)
        // ->with(['patient', 'room' => function ($query) {
        //     $query->withTrashed(); // Include the deleted rooms
        // }]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('patient-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
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
            Column::make('patient_id')->visible(true)->title('PatientID')->searchable(true),
            Column::make('id')->visible(false),
            Column::make('name_link')->data('name_link')->title('Name')->searchable(true)->orderData(true),
            Column::make('name')->visible(false),
            Column::make('date_of_birth')->searchable(true),
            Column::make('gender')->searchable(true),

            Column::make('age')
                ->data('age')
                ->title('Age')
                ->orderable(true)
                ->orderData(4)
                ->addClass('text-center'),

            Column::make('address.district.name_en')->data('address.district.name_en')->title('District')->searchable(true)->orderable(false),
            //  Column::make('')
            //   Column::computed('district')->searchable(true),
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
        return 'patient_' . date('YmdHis');
    }
}