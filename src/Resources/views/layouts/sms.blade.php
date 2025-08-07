<x-admin::layouts>
    <x-slot:title>
        @yield('title') - @lang('seven::app.name')
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <div class="text-xl font-bold dark:text-white">
                    @yield('heading')
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <form method="POST" action="{{ route('admin.seven.sms_submit') }}">
                @csrf

                <input name="id" value="{{ $id ?? null }}" type="hidden"/>
                <input name="entityType" value="{{ $entityType }}" type="hidden"/>

                @yield('filters')

                <x-seven-sms-flash></x-seven-sms-flash>
                <x-seven-sms-performance-tracking></x-seven-sms-performance-tracking>
                <x-seven-sms-from></x-seven-sms-from>
                <x-seven-sms-text></x-seven-sms-text>

                <button type='submit' class='primary-button'>@lang('seven::app.send_sms')</button>
            </form>
        </div>
    </div>
</x-admin::layouts>
