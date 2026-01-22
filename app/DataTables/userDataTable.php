<?php

namespace App\DataTables;

use App\Models\user;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class userDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('roles', function ($item) {
            $roleClasses = [
                'admin' => 'badge badge-success',
                'view-only' => 'badge badge-info',
                'editor' => 'badge badge-warning',
            ];
        
            $labels = '';
            foreach ($item->getRoleNames() as $role) {
                $class = $roleClasses[$role] ?? 'badge badge-secondary'; 
                $label = ucfirst($role); 
                $labels .= '<label class="' . $class . '">' . $label . '</label>';
            }
        
            return $labels;
        })
                
        ->addColumn('name',function($item){
            return $item->first_name.' '.$item->last_name . ' [' . $item->designation.']';            
        })
        ->addColumn('action', function($item){
            $user = Auth()->user(); 
            $btn = '';
            if($user->can('user-edit')){
            $btn .=  '<a href="'.route('users.edit',$item->id).'" class="btn btn-info  btn-circle btn-sm" data-bs-toggle="tooltip" title="Edit User"><i class="fa fa-pen"></i></a>';
            }
            $btn .=  '<a href="'.route('users.show',$item->id).'" class="btn btn-sm  btn-warning btn-circle "  data-bs-toggle="tooltip" title="Show" ><i class="fa fa-eye"></i></a>';
            if($user->can('user-reset-password')){
           $btn .= '<a href="'.route('users.resetpass',$item->id).'" class="btn btn-sm btn-primary btn-circle " data-bs-toggle="tooltip" title="Reset Password"><i class="fa fa-recycle"></i> </a>';
            }
            if($user->can('user-delete')){
                $btn .=  '<button data-bs-toggle="tooltip" title="Inactive User" class="btn btn-danger btn-circle btn-sm delete-btn" data-id="'.$item->id.'"> <i class="fa fa-trash-alt"></i></button>';
            $btn .= '<form  action="'. route('users.destroy',$item->id).'" method="POST" class="d-inline"  id="del'.$item->id.'">
            '.csrf_field().' '.method_field("DELETE").' <button type="submit"  class="btn btn-sm btn-danger btn-circle d-none"   
            onclick="return confirm(\'Do you need to delete this User\');"> 
            <i class="fa fa-trash-alt"></i></button>  
            </form>';
            }
            return $btn; 
        })
            ->addIndexColumn()
            ->rawColumns(['roles','action'])
            ->setRowId('id')
            ;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(user $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
             //       ->dom('Bfrtip')
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
            Column::make('user_name')->title('User Name'),
            Column::make('name')->orderable(false),
            Column::make('email')->addClass('lowercase')->title('Email'),
            COlumn::make('contact_number')->title('Mobile'),
            Column::make('roles')->searchable(false)
            ->orderable(false),
            Column::computed('action')
            ->title('')
            ->exportable(false)
            ->printable(false)
            ->searchable(false)
            ->orderable(false)
            ->width(150)
            ->addClass('text-center'),
            Column::make('first_name')->hidden(true)->searchable(true),
            Column::make('last_name')->hidden(true)->searchable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'user_' . date('YmdHis');
    }
}