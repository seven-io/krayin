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

            <div class='page-action'></div>
        </div>

        <form method='POST' action='{{ route('admin.sms77.sms_submit') }}'>
            @csrf()

            <div class='page-content'>
                <input name='entityType' value='{{ $entityType }}' type='hidden'/>
                <input name='id' value='{{ $id }}' type='hidden'/>

                <div class='form-group' :class='[errors.has(`flash`) ? `has-error` : ``]'>
                    <label for='flash'>
                        @lang('sms77::app.flash')
                    </label>

                    <label class='switch'>
                        <input
                                class='control'
                                id='flash'
                                name='flash'
                                type='checkbox'
                                {{ old('flash') ? 'checked' : '' }}
                        />

                        <span class='slider round'></span>
                    </label>
                </div>

                <div class='form-group' :class='[errors.has(`from`) ? `has-error` : ``]'>
                    <label for='from'>
                        @lang('sms77::app.from')
                    </label>

                    <input
                            class='control'
                            data-vv-as='&quot;@lang('sms77::app.from')&quot;'
                            name='from'
                            id='from'
                            v-validate='{
                             max: 16,
                             regex: /^([+]?[0-9]{1,16}|[a-zA-Z0-9 \-_+/()&$!,.@]{1,11})$/
                            }'
                            value='{{ old('from') }}'
                    />

                    <span class='control-error' v-if='errors.has(`from`)'>
                        @{{ errors.first('from') }}
                    </span>
                </div>

                <div class='form-group' :class='[errors.has(`text`) ? `has-error` : ``]'>
                    <label for='text' class='required'>
                        @lang('sms77::app.text')
                    </label>

                    <textarea
                            class='control'
                            data-vv-as='&quot;@lang('sms77::app.text')&quot;'
                            id='text'
                            name='text'
                            v-validate='`required|max:1520`'
                    >{{ old('text') }}</textarea>

                    <span class='control-error' v-if='errors.has(`text`)'>
                        @{{ errors.first('text') }}
                    </span>
                </div>

                <button type='submit' class='btn btn-md btn-primary'>
                    @lang('sms77::app.send_sms')
                </button>
            </div>
        </form>
    </div>
@stop