@extends('admin::layouts.master')

@section('page_title')
    sms77
@stop

@section('content-wrapper')
    <div class='content full-page dashboard'>
        <div class='page-header'>
            <div class='page-title'>
                <h1>sms77</h1>
            </div>

            <div class='page-action'></div>
        </div>

        <div class='page-content'>
            <p>
                @lang('sms77::app.about')
            </p>

            <a href='https://www.sms77.io' target='_blank'>
                <img alt='' src='{{ asset('vendor/sms77/assets/images/sms77.png') }}'/>
            </a>
        </div>
    </div>
@stop