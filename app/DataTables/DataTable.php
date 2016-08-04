<?php

namespace App\DataTables;

use Yajra\Datatables\Services\DataTable as YajraDataTable;

abstract class DataTable extends YajraDataTable
{
    protected $order = [[1, 'asc']];

    protected function getBuilderParameters()
    {
        return [
            'order' => $this->order,
            'buttons' => [],
            'pageLength' => 25,
            'language' => [
                'emptyTable' => __('Keine Daten in der Tabelle vorhanden'),
                'info' => __('_START_ bis _END_ von _TOTAL_ Einträgen'),
                'infoEmpty' => __('Keine Einträge vorhanden.'),
                'infoFiltered' => __('(gefiltert von _MAX_ Einträgen)'),
                'infoPostFix' => '',
                'infoThousands' => __('DECIMALPOINT'),
                'lengthMenu' => __('_MENU_ Einträge anzeigen'),
                'loadingRecords' => __('Wird geladen ...'),
                'processing' => __('Bitte warten ...'),
                'search' => __('Suchen'),
                'zeroRecords' => __('Keine Einträge vorhanden.'),
                'paginate' => [
                    'first' => __('Erste'),
                    'previous' => __('Zurück'),
                    'next' => __('Nächste'),
                    'last' => __('Letzte'),
                ],
                'aria' => [
                    'sortAscending' => __(' => aktivieren, um Spalte aufsteigend zu sortieren'),
                    'sortDescending' => __(' => aktivieren, um Spalte absteigend zu sortieren'),
                ],
            ],
        ];
    }
}
