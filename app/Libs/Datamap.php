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
}
