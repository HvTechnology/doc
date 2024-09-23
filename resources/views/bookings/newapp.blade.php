<x-app-layout>
<form
    x-on:submit.prevent="submit"
    x-data="appointmentForm()"
    class="space-y-12"
>
    <!-- Date Selection -->
    <div>
        <h2 class="text-lg font-medium mt-3">1. When for?</h2>
        <div x-data="datePicker()" x-init="initDatePicker">
            <input x-ref="date" class="mt-6 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full" placeholder="Choose a date">
        </div>
    </div>

    <!-- Time Slot Selection -->
    <div x-data="timeSlotSelection()" x-on:slots-requested.window="fetchSlots">
        <h2 class="text-lg font-medium mt-3">2. Choose a time slot</h2>
        <div class="mt-6" x-show="slots.length">
            <div class="grid grid-cols-3 md:grid-cols-5 gap-8 mt-6">
                <template x-for="slot in slots" :key="slot">
                    <div
                        x-text="slot"
                        class="py-3 px-4 text-sm border border-slate-200 rounded-lg text-center hover:bg-gray-50/75 cursor-pointer"
                        x-on:click="selectSlot(slot)"
                        x-bind:class="{ 'bg-slate-100 hover:bg-slate-100': form.time === slot }"
                    ></div>
                </template>
            </div>
        </div>
    </div>

    <!-- Display Prefilled Information -->
    <div class="mt-6">
        <h2 class="text-lg font-medium mt-3">3. Confirm Your Details</h2>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Name:</label>
            <p class="mt-1 text-sm text-gray-900">{{ $patient->name }}</p>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Email:</label>
            <p class="mt-1 text-sm text-gray-900">{{ $patient->email }}</p>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Codice Fiscale:</label>
            <p class="mt-1 text-sm text-gray-900">{{ $patient->codice_fiscale }}</p>
        </div>
    </div>

    <!-- Hidden Fields -->
    <div x-cloak>
        <input type="hidden" name="employee_id" x-model="form.employee_id">
        <input type="hidden" name="service_id" x-model="form.service_id">
        <input type="hidden" name="name" x-model="form.name">
        <input type="hidden" name="email" x-model="form.email">
        <input type="hidden" name="codice_fiscale" x-model="form.codice_fiscale">
    </div>

    <!-- Submit Button -->
    <div class="mt-6" x-show="form.time" x-cloak>
        <button
            type="submit"
            class="py-3 px-6 text-sm border border-slate-200 rounded-lg flex items-center justify-center text-center hover:bg-slate-900 cursor-pointer bg-slate-800 text-white font-medium"
        >
            Book Appointment
        </button>
    </div>
</form>

<!-- Alpine.js Component Scripts -->
<script>
    function appointmentForm() {
        return {
            error: null,
            form: {
                employee_id: 1,
                service_id: 1,
                date: null,
                time: null,
                name: @json($patient->name),
                email: @json($patient->email),
                codice_fiscale: @json($patient->codice_fiscale)
            },
            submit() {
                axios.post('{{ route('appointments') }}', this.form)
                    .then((response) => {
                        window.location = response.data.redirect;
                    })
                    .catch((error) => {
                        console.error(error.response.data);
                        this.error = error.response.data.message || 'An error occurred.';
                    });
            }
        };
    }

    function datePicker() {
        return {
            availableDates: @json($availableDates),
            picker: null,
            initDatePicker() {
                const { availableDates } = this;
                this.picker = new easepick.create({
                    element: this.$refs.date,
                    readonly: true,
                    zIndex: 50,
                    date: '{{ $firstAvailableDate }}',
                    css: [
                        'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
                        '/vendor/easepick/easepick.css'
                    ],
                    plugins: ['LockPlugin'],
                    LockPlugin: {
                        minDate: new Date(),
                        filter(date) {
                            return !Object.keys(availableDates).includes(date.format('YYYY-MM-DD'));
                        }
                    },
                    setup(picker) {
                        picker.on('select', (e) => {
                            const selectedDate = e.detail.date.format('YYYY-MM-DD');
                            this.$parent.form.date = selectedDate;
                            this.$dispatch('slots-requested');
                        });
                    }
                });
            }
        };
    }

    function timeSlotSelection() {
        return {
            slots: [],
            fetchSlots() {
                const date = this.$parent.form.date;
                axios.get(`{{ route('slots', [$employee, $service]) }}?date=${date}`)
                    .then((response) => {
                        this.slots = response.data.times;
                    });
            },
            selectSlot(slot) {
                this.$parent.form.time = slot;
            }
        };
    }
</script>
</x-app-layout>
