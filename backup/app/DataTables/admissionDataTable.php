<?php

namespace App\DataTables;

use App\Models\admission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class admissionDataTable extends DataTable
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
                return '<a href="' . route('admission.show', ['id' => $item->id, 'type' => 'current']) . '">' . $item->id . '</a>';

            })
            ->addColumn('patient_name', function ($item) {
                return $item->patient->patient_id . ': ' . $item->patient->name;
            })
            ->addColumn('user_name', function($item) {
                $userName = '';
                $userInfo = '';
                $logType = '';
                if ($item->createdBy->user_name) {
                    $userName = $item->createdBy->user_name ? $item->createdBy->user_name : '';
                    $userInfo = $item->createdBy;
                    $userInfo->log_type = "CREATE";
                } elseif ($item->updatedBy->user_name) {
                    $userName = $item->updatedBy->user_name ? $item->updatedBy->user_name : '';
                    $userInfo = $item->updatedBy;
                    $userInfo->log_type = "UPDATE";
                } elseif ($item->deletedBy->user_name) {
                    $userName = $item->deletedBy->user_name ? $item->deletedBy->user_name : '';
                    $userInfo = $item->deletedBy;
                    $userInfo->log_type = "DELETE";
                }
    
                return '<span data-order="'.$item->id.'" class="badge badge-info user-popup" style="cursor: pointer;" data-user-info="' . htmlspecialchars(json_encode($userInfo)) . '" data-updated-at="' . $item->updated_at . '" log-type="' . $logType . '">' . $userName . '</span>';
           
            })
            ->addColumn('action', function ($item) {
                $user = Auth()->user();
                $btn = ''; 
                if ($user->can('daily-visit-list')) {
                    $btn .= '<a class="btn btn-primsary  btn-circle btn-sm" data-bs-toggle="tooltip"   href="' . route('daily-visit.create', $item->id) . '" title="Daily Notes"><i style="color:#183153" class="fa-solid fa-notes-medical fa-2xl"></i></a> ';
                }
                if ($user->can('admission-edit')) {
                    $btn .= '<a class="btn btn-info  btn-circle btn-sm" href="' . route('admission.edit', $item->id) . '"  data-bs-toggle="tooltip"   title="Edit"><i class="fa fa-pen"></i></a> ';
                }
                if ($user->can('admission-medical-create')) {
                    $btn .= '<a class="btn bg-success text-white btn-circle btn-sm" href="' . route('medical.create', $item->id) . '"  data-bs-toggle="tooltip"   title="Add Medical Details"><i class="fa fa-solid fa-plus"></i></a>';
                }

                 // discharge action
                 if ($user->can('discharge')) {
                   
                    $btn .= '<button class="btn  btn-circle btn-sm discharge-btn"  data-bs-toggle="tooltip" title="Make Discharge"  data-id="' . $item->id . '"><i title="Make Discharge" class="fa-solid fa-message-smile fa-2xl" style="color: #B197FC;"></i> </button>&nbsp;';
                }
               
                if ($user->can('admission-delete')) {
                    $btn .= '<button class="btn btn-danger btn-circle btn-sm delete-btn" data-id="' . $item->id . '"  data-bs-toggle="tooltip"  title="Delete"> <i class="fa fa-trash-alt"></i></button>';
                    $btn .= '<form  action="' . route('admission.destroy', $item->id) . '" method="POST" class="d-inline"  id="del' . $item->id . '">
                    
       ' . csrf_field() . ' ' . method_field("DELETE") . ' <button type="submit"  class="btn btn-danger btn-circle btn-sm d-none"   data-toggle="tooltip" title="Delete"
       onclick="return confirm(\'Do you need to delete this ? \');" title="Delete">
       <i class="fa fa-trash-alt"></i></button>
       </form>';
                }
              

                
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['id','user_name','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(admission $model): QueryBuilder 
    {
        $searchValue = request()->input('search.value');
        $orderByColumnIndex = request()->input('order.0.column');
        $orderByDirection = request()->input('order.0.dir');
        
        return $model->select('admissions.*')
            ->where(function ($query) {
                $query->where('date_of_check_out', '=', null)
                    ->orWhereNull('date_of_check_out');
            })
            ->with([
                'patient',
                'createdBy',
                'updatedBy',
                'deletedBy',
                'room' => function ($query) {
                    $query->withTrashed(); // Include the deleted rooms
                }
            ])
            ->when($searchValue, function ($query) use ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->whereHas('createdBy', function ($query) use ($searchValue) {
                        $query->where('user_name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('updatedBy', function ($query) use ($searchValue) {
                        $query->where('user_name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('deletedBy', function ($query) use ($searchValue) {
                        $query->where('user_name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhere(function ($query) use ($searchValue) {
                        // Search for Patient ID or Name separately
                        $query->whereHas('patient', function ($query) use ($searchValue) {
                            $query->where('patient_id', 'like', '%' . $searchValue . '%')
                                ->orWhere('name', 'like', '%' . $searchValue . '%');
                        });
                    })
                    ->orWhereHas('patient', function ($query) use ($searchValue) {
                        // Search for a combination of Patient ID and Name
                        $query->whereRaw("CONCAT(patient_id, ' ', name) like ?", ['%' . $searchValue . '%']);
                    })
                    ->orWhere('admissions.id', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('room', function ($query) use ($searchValue) {
                        $query->where('room_number', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhere('date_of_check_in', 'like', '%' . $searchValue)
                    ->orWhere('plan_to_check_out', 'like', '%' . $searchValue . '%');
                })
                ->orWhere(function ($query) use ($searchValue) {
                    $query->where(function ($query) use ($searchValue) {
                        $query->whereNull('date_of_check_out')
                              ->orWhere('date_of_check_out', '=', null);
                    })
                    ->where('admissions.id', '=', $searchValue);
                }); 
            })
            ->when($orderByColumnIndex !== null, function ($query) use ($orderByColumnIndex, $orderByDirection) {
                if ($orderByColumnIndex == 2) {
                    // Sort by Admission ID
                    $query->orderBy('patient_id', $orderByDirection);
                } elseif ($orderByColumnIndex == 1) {
                    // Sort by Patient ID
                    $query->orderBy('id', $orderByDirection);
                } elseif ($orderByColumnIndex == 3) {
                    // Sort by Room Number
                    $query->orderBy('room_number', $orderByDirection)
                        ->join('rooms', 'rooms.id', '=', 'admissions.room_id');
                } elseif ($orderByColumnIndex == 4) {
                    // Sort by Check In
                    $query->orderBy('date_of_check_in', $orderByDirection);
                } elseif ($orderByColumnIndex == 5) {
                    // Sort by Check Out
                    $query->orderBy('plan_to_check_out', $orderByDirection);
                } elseif ($orderByColumnIndex == 6) {
                    // Sort by User Name
                    $query->orderBy('users.user_name', $orderByDirection)
                        ->join('users', 'users.id', '=', 'admissions.user_id');
                }
            });
    }
    
    
    
    

    




    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('admission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('id')->data('id')->title('Admission ID')
            ->orderable(true)
            ->searchable(true),
            Column::computed('patient_name')
            ->title('Patient ID & Name')
            ->data('patient_name')
            ->orderable(true)
            ->searchable(true),
            Column::make('room.room_number')->data('room.room_number')->title('Room number'),
            Column::make('date_of_check_in')->data('date_of_check_in')->title('Check In'),
            Column::make('plan_to_check_out')->data('plan_to_check_out')->title('Check Out'),
            Column::make('user_name')
            ->data('user_name')
            ->title('User')
            ->orderable(true) 
            ->orderData(4),
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
        return 'admission_' . date('YmdHis');
    }
}
