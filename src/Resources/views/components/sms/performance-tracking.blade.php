<x-admin::form.control-group class="mb-4">
    <x-admin::form.control-group.label>
        @lang('seven::app.performance_tracking')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="switch"
        name="performance_tracking"
        :checked="old('performance_tracking')"
        value='1'
    />

    <x-admin::form.control-group.error control-name="performance_tracking" />
</x-admin::form.control-group>
