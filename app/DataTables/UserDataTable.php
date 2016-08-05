<?php

namespace App\DataTables;

use App\Models\User;

class UserDataTable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', function (User $user) {
                $actions = '<div class="text-center">';
                if(\Auth::user()->can('edit', $user)) {
                    $actions .= '<a href = "'.route('app.management.get.user.edit', $user->getKey()).'" title = "'.__('Bearbeiten').'" ><i class="icon wh-edit" ></i ></a>';
                }
                $actions .= '</div>';
                return $actions;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::query();

        return $this->applyScopes($users);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->addAction(['title' => ''])
            ->columns($this->getColumns())
            ->ajax('')
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'email' => [
                'title' => __('E-Mail'),
            ],
            'nickname' => [
                'title' => __('Benutzername'),
            ],
            'first_name' => [
                'title' => __('Vorname'),
            ],
            'last_name' => [
                'title' => __('Nachname'),
            ],
        ];
    }
}
