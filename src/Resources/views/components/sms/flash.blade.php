<x-admin::form.control-group class="mb-4">
    <x-admin::form.control-group.label>
        @lang('seven::app.flash')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="switch"
        name="flash"
        :checked="old('flash')"
        value='1'
    />

    <x-admin::form.control-group.error control-name="flash" />
</x-admin::form.control-group>
