<x-app-layout>
    <div class="submissions-wrapper lms-module-shell space-y-6">
        <x-lms-page-header
            :title="__('lms.grade.submissions_title', ['title' => $assignment->title])"
            :subtitle="$class->title"
            :back-url="route('instruktur.classes.stream', $class)"
            :back-label="__('lms.common.back_to_class')"
            :breadcrumbs="[
                ['label' => __('lms.nav.my_classes'), 'url' => route('instruktur.classes.index')],
                ['label' => $class->title, 'url' => route('instruktur.classes.stream', $class)],
                ['label' => __('lms.grade.submissions')],
            ]"
        />

        <x-lms-session-flash />

        <x-lms-stat-grid>
            <x-lms-stat-card
                :label="__('lms.common.total')"
                :value="$stats['total']"
                icon="clipboard"
                tone="blue"
            />
            <x-lms-stat-card
                :label="__('lms.common.submitted')"
                :value="$stats['submitted']"
                icon="check-circle"
                tone="green"
            />
            <x-lms-stat-card
                :label="__('lms.grade.late')"
                :value="$stats['late']"
                icon="clock"
                tone="amber"
            />
            <x-lms-stat-card
                :label="__('lms.common.graded')"
                :value="$stats['graded']"
                icon="document"
                tone="indigo"
            />
        </x-lms-stat-grid>

        <x-lms-card class="table-card p-0 overflow-hidden" :title="__('lms.grade.submissions')" :meta="__('lms.grade.index_hint')">
            <x-lms-data-table :paginator="$submissions" :skeleton-cols="5">
                <x-slot:head>
                    <tr>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.attendance.student') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--left">{{ __('lms.grade.submitted_at') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.status') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.grade.score_label') }}</th>
                        <th class="lms-data-table__th lms-data-table__th--center">{{ __('lms.common.actions') }}</th>
                    </tr>
                </x-slot:head>

                @forelse($submissions as $s)
                    <tr class="submission-row transition">
                        <td class="px-6 py-4 text-slate-800 dark:text-slate-100 font-medium">{{ $s->participant->name }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm">{{ $s->submitted_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($s->status == 'graded')
                                <span class="lms-badge lms-badge--success">{{ __('lms.common.graded') }}</span>
                            @elseif($s->status == 'late')
                                <span class="lms-badge lms-badge--danger">{{ __('lms.grade.late') }}</span>
                            @else
                                <span class="lms-badge lms-badge--info">{{ __('lms.common.submitted') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-slate-700 dark:text-slate-200">{{ $s->score ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <x-lms-row-actions>
                                <x-lms-action-btn variant="view" :href="route('instruktur.grades.show', [$class, $assignment, $s])">{{ __('lms.grade.grade_btn') }}</x-lms-action-btn>
                            </x-lms-row-actions>
                        </td>
                    </tr>
                @empty
                    <x-lms-table-empty
                        :colspan="5"
                        :message="__('lms.grade.no_submissions')"
                        :description="__('lms.grade.no_submissions_hint')"
                        icon="document"
                    />
                @endforelse
            </x-lms-data-table>
        </x-lms-card>
    </div>
</x-app-layout>
