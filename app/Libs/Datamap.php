<?php
namespace App\Libs;

class Datamap
{
    public function getYesNo($id = null)
    {
        $options = collect([
            0 => __('Nein'),
            1 => __('Ja'),
        ]);

        if (is_null($id)) {
            return $options;
        } else {
            return $options->get($id);
        }
    }

    public function getLanguages()
    {
        return collect([
            [
                'locale' => 'de-de',
                'display_name' => __('Deutsch'),
            ]
        ]);
    }

    public function getNotificationStyles()
    {
        return collect([
            'info' => [
                'name' => 'info',
                'icon' => 'wh-pin',
                'style' => 'info',
            ],
            'success' => [
                'name' => 'success',
                'icon' => 'wh-ok',
                'style' => 'success',
            ],
            'warning' => [
                'name' => 'warning',
                'icon' => 'wh-alertalt',
                'style' => 'warning',
            ],
            'error' => [
                'name' => 'error',
                'icon' => 'wh-bomb',
                'style' => 'danger',
            ],
        ]);
    }

    public function getNotificationStyle($name)
    {
        return $this->getNotificationStyles()->whereLoose('name', $name)->first();
    }

    public function getNotificationStyleByCategory($category)
    {
        $info = [];
        $success = [];
        $warning = [];
        $error = [];

        if(in_array($category, $info)) {
            return $this->getNotificationStyle('info');
        } elseif(in_array($category, $success)) {
            return $this->getNotificationStyle('success');
        } elseif(in_array($category, $warning)) {
            return $this->getNotificationStyle('warning');
        } elseif(in_array($category, $error)) {
            return $this->getNotificationStyle('error');
        } else {
            return $this->getNotificationStyle('info');
        }
    }

    public function getCalendars()
    {
        return collect([
            'ships' => [
                'name' => 'ships',
                'display_name' => __('Schiffe'),
                'gcid' => 'oc1dig3hpl8p2lvreqg4q25anc@group.calendar.google.com'
            ],
            'fireworks' => [
                'name' => 'fireworks',
                'display_name' => __('Feuerwerke'),
                'gcid' => '1lkh6r76dingfr1rnl1nctfjos@group.calendar.google.com'
            ],
            'events' => [
                'name' => 'events',
                'display_name' => __('Veranstaltungen'),
                'gcid' => '8cdmotrjirkl994kp066pcd93s@group.calendar.google.com'
            ],
            'nature' => [
                'name' => 'nature',
                'display_name' => __('Naturphänomene'),
                'gcid' => '1adrg0boc0sabgudl6e2ffpha8@group.calendar.google.com'
            ],
        ]);
    }

    public function getCalendarById($gcid)
    {
        return $this->getCalendars()->whereLoose('gcid', $gcid)->first();
    }

    public function getCalendarByName($name)
    {
        return $this->getCalendars()->whereLoose('name', $name)->first();
    }
}
