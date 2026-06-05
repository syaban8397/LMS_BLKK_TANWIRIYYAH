<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl">
            User Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">

                <h3 class="text-xl font-bold mb-4">
                    Participant List
                </h3>

                <div class="overflow-x-auto">

                    <table class="w-full border border-gray-200">

                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border text-left">Name</th>
                                <th class="p-3 border text-left">Email</th>
                                <th class="p-3 border text-left">Role</th>
                                <th class="p-3 border text-left">Status</th>
                                <th class="p-3 border text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td class="p-3 border">
                                        {{ $user->name }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $user->email }}
                                    </td>

                                    <td class="p-3 border">
                                        <span class="capitalize">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    <td class="p-3 border">

                                        @switch($user->approval_status)

                                            @case('approved')
                                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                    Approved
                                                </span>
                                            @break

                                            @case('rejected')
                                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                    Rejected
                                                </span>
                                            @break

                                            @default
                                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                                    Pending
                                                </span>

                                        @endswitch

                                    </td>

                                    <td class="p-3 border">

                                        @if($user->role === 'peserta')

                                            <form
                                                action="{{ route('admin.users.status', $user->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <div class="flex items-center gap-2">

                                                    <select
                                                        name="approval_status"
                                                        class="border rounded-lg px-3 py-2 text-sm">

                                                        <option
                                                            value="pending"
                                                            {{ $user->approval_status == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>

                                                        <option
                                                            value="approved"
                                                            {{ $user->approval_status == 'approved' ? 'selected' : '' }}>
                                                            Approved
                                                        </option>

                                                        <option
                                                            value="rejected"
                                                            {{ $user->approval_status == 'rejected' ? 'selected' : '' }}>
                                                            Rejected
                                                        </option>

                                                    </select>

                                                    <button
                                                        type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">

                                                        Save

                                                    </button>

                                                </div>

                                            </form>

                                        @else

                                            <span class="text-gray-400">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center p-4 text-gray-500">
                                        No participants found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>