<?php

return [

    'confirmed'            => __('Die :attribute Bestätigung stimmt nicht überein.'),
    'email'                => __('Das :attribute Feld muss eine gültige E-Mail Adresse beinhalten.'),
    'required'             => __('Das :attribute Feld wird benötigt.'),
    'min' => [
        'string' => __('Das :attribute Feld muss mindestens :min Zeichen lang sein.'),
    ],
    'unique' => __('Das :attribute Feld muss einen einmaligen Wert haben.'),
    'github_repo' => __('Bitte gib den Namen eines GitHub-Repos ein.'),

    'custom' => [
        'password' => [
            'min' => __('Wählen Sie mindestens :min Zeichen.'),
        ]
    ],

    'attributes' => [
        'password' => trans('forms.password'),
        'email' => trans('forms.email'),
        'name' => trans('forms.name'),
    ],

];
