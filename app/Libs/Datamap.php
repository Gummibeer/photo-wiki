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
            ],
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

        if (in_array($category, $info)) {
            return $this->getNotificationStyle('info');
        } elseif (in_array($category, $success)) {
            return $this->getNotificationStyle('success');
        } elseif (in_array($category, $warning)) {
            return $this->getNotificationStyle('warning');
        } elseif (in_array($category, $error)) {
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
                'color' => [
                    'name' => 'blue',
                    'hex' => '#4e97d9',
                ],
                'gcid' => 'oc1dig3hpl8p2lvreqg4q25anc@group.calendar.google.com',
            ],
            'fireworks' => [
                'name' => 'fireworks',
                'display_name' => __('Feuerwerke'),
                'color' => [
                    'name' => 'red',
                    'hex' => '#e9595b',
                ],
                'gcid' => '1lkh6r76dingfr1rnl1nctfjos@group.calendar.google.com',
            ],
            'events' => [
                'name' => 'events',
                'display_name' => __('Veranstaltungen'),
                'color' => [
                    'name' => 'purple',
                    'hex' => '#7c51d1',
                ],
                'gcid' => '8cdmotrjirkl994kp066pcd93s@group.calendar.google.com',
            ],
            'nature' => [
                'name' => 'nature',
                'display_name' => __('Naturphänomene'),
                'color' => [
                    'name' => 'green',
                    'hex' => '#83b944',
                ],
                'gcid' => '1adrg0boc0sabgudl6e2ffpha8@group.calendar.google.com',
            ],
            'sport' => [
                'name' => 'sport',
                'display_name' => __('Sport'),
                'color' => [
                    'name' => 'cyan',
                    'hex' => '#47b8c6',
                ],
                'gcid' => 'vk6rld3s35vipld18b2mc02mgg@group.calendar.google.com',
            ],
            'tours' => [
                'name' => 'tours',
                'display_name' => __('Fototouren'),
                'color' => [
                    'name' => 'yellow',
                    'hex' => '#fbc02d',
                ],
                'gcid' => 'rubc3fvlhp226ju0jogjl6bhs8@group.calendar.google.com',
            ],
            'workshops' => [
                'name' => 'workshops',
                'display_name' => __('Workshops'),
                'color' => [
                    'name' => 'pink',
                    'hex' => '#e53b75',
                ],
                'gcid' => 'f986g59kbo6ccmdgggdk3pqk6s@group.calendar.google.com',
            ],
            'default' => [
                'name' => 'default',
                'display_name' => __('Sonstige'),
                'color' => [
                    'name' => 'grey',
                    'hex' => '#757575',
                ],
                'gcid' => '55ctsb2758si9pq11hctonuv48@group.calendar.google.com',
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
