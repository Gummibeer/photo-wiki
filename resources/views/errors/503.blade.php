@extends('layouts.error')

@section('head-title', __('Wartungsarbeiten'))
@section('page-title', config('app.name'))
@section('error-code', '503')
@section('error-message', __('Die Anwendung braucht eine kurze Auszeit.'))