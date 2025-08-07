@extends('seven::layouts.sms')

@section('title')
    @lang('seven::app.send_sms_bulk')
@endsection

@section('heading')
    @lang('seven::app.send_sms_bulk')
@endsection

@section('filters')
    <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
        <p class="text-blue-800 dark:text-blue-200">
            @lang('seven::app.about_bulk')
        </p>
    </div>
@endsection
