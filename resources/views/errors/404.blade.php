@extends('layouts.error')

@section('head-title', $errorCode = '404')
@section('page-title', config('app.name'))
@section('error-code', $errorCode)
@section('error-message', __('Die Seite, die Sie suchen ist möglicherweise entfernt worden.'))
