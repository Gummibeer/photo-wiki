@extends('layouts.error')

@section('head-title', $errorCode = config('app.debug') ? 403 : 404)
@section('page-title', config('app.name'))
@section('error-code', $errorCode)
@section('error-message', config('app.debug') ? __('Keinen Zugriff!') : __('Die Seite, die Sie suchen ist möglicherweise entfernt worden.'))
