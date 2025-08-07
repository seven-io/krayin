<x-admin::form.control-group class="mb-4">
    <x-admin::form.control-group.label class="required">
        @lang('seven::app.text')
    </x-admin::form.control-group.label>

    <x-admin::form.control-group.control
        type="textarea"
        name="text"
        rules="required|max:1520"
        value="{{ old('text') }}"
        rows="5"
        :placeholder="trans('seven::app.text_placeholder')"
    />

    <x-admin::form.control-group.error control-name="text" />
</x-admin::form.control-group>
