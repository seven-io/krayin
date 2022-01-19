@extends('admin::layouts.master')

@section('page_title')
    @lang('sms77::app.send_sms') - sms77
@stop

@section('content-wrapper')

    <div class='content full-page dashboard'>
        <div class='page-header'>
            <div class='page-title'>
                <h1>@lang('sms77::app.send_sms')</h1>
            </div>

            <div class='page-action'>

            </div>
        </div>

        <form method='POST' action='{{ route('admin.sms77.sms_submit') }}'>
            @csrf()

            <div class='page-content'>
                <input name="id" value="{{ $id }}" type='hidden'/>

                <div class="form-group" :class="[errors.has('text') ? 'has-error' : '']">
                    <label for="text" class="required">
                        @lang('sms77::app.text')
                    </label>

                    <textarea
                            name="text"
                            class="control"
                            id="text"
                            v-validate="'required'"
                            data-vv-as="&quot;@lang('sms77::app.text')&quot;"
                    >{{ old('text') }}</textarea>

                    <span class="control-error" v-if="errors.has('text')">
                        @{{ errors.first('text') }}
                    </span>
                </div>

                <button type="submit" class="btn btn-md btn-primary">
                    @lang('sms77::app.send_sms')
                </button>
            </div>
        </form>
    </div>
@stop