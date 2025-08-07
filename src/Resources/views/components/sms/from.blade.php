<x-admin::form.control-group class="mb-4">
    <x-admin::form.control-group.label>
        @lang('seven::app.from')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="text"
        name="from"
        value="{{ old('from') }}"
        placeholder='Krayin'
        rules="max:16|regex:/^([+]?[0-9]{1,16}|[a-zA-Z0-9 \-_+\/()&$!,.@]{1,11})$/"
    />

    <x-admin::form.control-group.error control-name="from" />
</x-admin::form.control-group>
