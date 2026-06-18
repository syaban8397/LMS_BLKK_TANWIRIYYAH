<x-app-layout>

    <div class="lms-page-shell space-y-5">

        <x-lms-page-header :title="__('lms.nav.classes')" :subtitle="__('lms.common.manage_classes_desc')">

            <x-slot:actions>

                <a href="{{ route('admin.classes.create') }}" class="lms-btn-primary">{{ __('lms.common.new_class') }}</a>

            </x-slot:actions>

        </x-lms-page-header>



        @if(session('success'))

            <x-lms-flash type="success">{{ session('success') }}</x-lms-flash>

        @endif



        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="stat-card p-4">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.total_classes') }}</p>

                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalClasses }}</p>

                    </div>

                    <div class="lms-kpi-icon bg-blue-50 dark:bg-blue-950/40">📚</div>

                </div>

            </div>

            <div class="stat-card p-4">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.active_classes') }}</p>

                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeClasses }}</p>

                    </div>

                    <div class="lms-kpi-icon bg-green-50 dark:bg-green-950/40">✅</div>

                </div>

            </div>

            <div class="stat-card p-4">

                <div class="flex justify-between items-start">

                    <div>

                        <p class="text-xs text-slate-400 uppercase tracking-wide">{{ __('lms.common.draft_classes') }}</p>

                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $draftClasses }}</p>

                    </div>

                    <div class="lms-kpi-icon bg-amber-50 dark:bg-amber-950/40">📝</div>

                </div>

            </div>

        </div>



        <div class="table-card overflow-hidden p-0">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr>

                            <th class="text-left">{{ __('lms.report.class_name') }}</th>

                            <th class="text-left">{{ __('lms.report.program') }}</th>

                            <th class="text-left">{{ __('lms.report.instructor') }}</th>

                            <th class="text-center">{{ __('lms.common.period') }}</th>

                            <th class="text-center">{{ __('lms.common.status') }}</th>

                            <th class="text-center">{{ __('lms.common.actions') }}</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($classes as $class)

                            <tr>

                                <td>

                                    <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $class->title }}</div>

                                    <div class="text-xs text-slate-500">{{ $class->code }}</div>

                                </td>

                                <td class="text-slate-600 dark:text-slate-300 text-xs">{{ $class->program->name }}</td>

                                <td class="text-slate-600 dark:text-slate-300 text-xs">{{ $class->instructor->name }}</td>

                                <td class="text-center text-slate-600 dark:text-slate-300 text-xs">

                                    {{ $class->start_date->format('d M Y') }} - {{ $class->end_date->format('d M Y') }}

                                </td>

                                <td class="text-center">

                                    @switch($class->status)

                                        @case('draft')

                                            <span class="lms-badge lms-badge--warning">{{ __('lms.common.draft') }}</span>

                                            @break

                                        @case('active')

                                            <span class="lms-badge lms-badge--success">{{ __('lms.active') }}</span>

                                            @break

                                        @case('completed')

                                            <span class="lms-badge lms-badge--info">{{ __('lms.common.completed') }}</span>

                                            @break

                                        @case('cancelled')

                                            <span class="lms-badge lms-badge--danger">{{ __('lms.common.cancelled') }}</span>

                                            @break

                                    @endswitch

                                </td>

                                <td>

                                    <div class="flex justify-center gap-1.5">

                                        <a href="{{ route('admin.classes.show', $class) }}" class="action-btn px-2 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-xs">{{ __('lms.view') }}</a>

                                        <a href="{{ route('admin.classes.edit', $class) }}" class="action-btn px-2 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs">{{ __('lms.edit') }}</a>

                                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" data-lms-confirm="{{ __('lms.common.delete_class') }}" class="inline">

                                            @csrf @method('DELETE')

                                            <button type="submit" class="action-btn px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">{{ __('lms.common.del') }}</button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="py-10 text-center text-slate-400 dark:text-slate-500 text-sm">{{ __('lms.common.no_classes_found') }}</td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700/50 text-xs">

                {{ $classes->links() }}

            </div>

        </div>

    </div>

</x-app-layout>

