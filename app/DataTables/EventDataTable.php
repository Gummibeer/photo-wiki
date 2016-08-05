<?php

namespace App\DataTables;

use App\Models\Event;

class EventDataTable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';
    protected $order = [[3, 'asc']];

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', function (Event $event) {
                $actions = '<div class="text-center"><ul class="list-inline margin-0">';
                if (\Auth::user()->can('approve', $event) && ! $event->approved) {
                    $actions .= '<li><a href = "'.route('app.management.get.event.approve', $event->getKey()).'" title = "'.__('bestätigen').'"><i class="icon wh-check text-success"></i></a></li>';
                }
                if (\Auth::user()->can('delete', $event)) {
                    $actions .= '<li><a href = "'.route('app.management.get.event.delete', $event->getKey()).'" title = "'.__('löschen').'"><i class="icon wh-trash text-danger"></i></a></li>';
                }
                $actions .= '</ul></div>';

                return $actions;
            })
            ->editColumn('starting_at', function ($row) {
                return carbon_datetime($row['starting_at']);
            })
            ->editColumn('ending_at', function ($row) {
                return carbon_datetime($row['ending_at']);
            })
            ->editColumn('all_day', function ($row) {
                return $row['all_day'] ? '<i class="icon wh-ok text-success"></i>' : '<i class="icon wh-remove text-danger"></i>';
            })
            ->editColumn('approved', function ($row) {
                return $row['approved'] ? '<i class="icon wh-ok text-success"></i>' : '<i class="icon wh-remove text-danger"></i>';
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
        $users = Event::query();

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
            'display_name' => [
                'title' => __('Name'),
            ],
            'approved' => [
                'title' => __('Bestätigt'),
            ],
            'starting_at' => [
                'title' => __('Start'),
            ],
            'ending_at' => [
                'title' => __('Ende'),
            ],
            'all_day' => [
                'title' => __('Ganztags'),
            ],
        ];
    }
}
