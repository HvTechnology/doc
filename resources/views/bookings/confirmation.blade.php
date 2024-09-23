<x-app-layout>
    <div class="space-y-12">
        <div>
            <h2 class="text-xl font-medium mt-3">{{ !$appointment->cancelled() ? 'Grazie, la tua prenotazione è avvenuta!' : 'Annullata' }}</h2>
            <div class="flex mt-6 space-x-3 bg-slate-100 rounded-lg p-4">
                <img src="{{ $appointment->employee->profile_photo_url }}" class="rounded-lg size-14 bg-slate-100">
                <div class="w-full">
                    <div class="flex justify-between">
                        <div class="font-semibold">
                            {{ $appointment->service->title }} ({{ $appointment->service->duration }} minuti)
                        </div>
                      
                    </div>
                    <div class="text-sm">
                        {{ $appointment->employee->name }}
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-medium mt-3">Quando</h2>
            <div class="mt-6 bg-slate-100 rounded-lg p-4">
                {{ $appointment->starts_at->translatedFormat('d F Y \a\\t H:i') }} fino alle {{ $appointment->ends_at->format('H:i') }}

            </div>
        </div>

        @if (!$appointment->cancelled())
            <form
                method="post"
                action="{{ route('appointments.destroy', $appointment) }}"
                x-data
                x-on:submit.prevent="
                    if (window.confirm('Sei sicuro?')) {
                        $el.submit()
                    }
                "
            >
                @csrf
                @method('DELETE')
                <button class="text-blue-500">Annulla appuntamento</button>
            </form>
        @endif
    </div>
</x-app-layout>
