<x-admin::form.control-group class="mb-4">
    <x-admin::form.control-group.label>
        @lang('seven::app.from')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="text"
        name="from"
        value="{{ old('from', $smsFrom) }}"
        placeholder='Krayin'
        rules="max:16"
    />

    <x-admin::form.control-group.error control-name="from" />
</x-admin::form.control-group>
