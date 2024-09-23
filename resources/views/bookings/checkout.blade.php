<x-app-layout>
    <form
        x-on:submit.prevent="submit"
        x-data="{
            error: null,
            errorCodiceFiscale: null,
            otpSent: false,
            otp: null,

            form: {
                employee_id: {{ $employee->id }},
                service_id: {{ $service->id }},
                date: null,
                time: null,
                name: null,
                email: null,
                codice_fiscale: null
            },

            validateCodiceFiscale () {
                const codice = this.form.codice_fiscale;

                if (codice.length > 16) {
                    this.errorCodiceFiscale = 'Il Codice fiscale non puo superare i 16 caratteri.';
                    return;
                } else if (codice.length < 16) {
                    this.errorCodiceFiscale = 'Il Codice fiscale deve essere lungo 16 caratteri.';
                    return;
                } else {
                    this.errorCodiceFiscale = null; // Clear the error if exactly 16 characters
                    this.checkCodiceFiscale(); // Proceed to check with the server
                }
            },

            checkCodiceFiscale () {
                axios.post('{{ route('check_codice_fiscale') }}', { codice_fiscale: this.form.codice_fiscale })
                .then(() => {
                    this.errorCodiceFiscale = null; // Codice Fiscale found
                })
                .catch(() => {
                    this.errorCodiceFiscale = 'Codice fiscale non trovato nel sistema.';
                });
            },

            sendOtp() {
                // Prevent sending OTP if Codice Fiscale is invalid
                if (this.errorCodiceFiscale !== null) {
                    this.error = 'Si prega di correggere il Codice fiscale prima di inviare il OTP.';
                    return;
                }
                
                // Send OTP if Codice Fiscale is valid
                axios.post('{{ route('send_otp') }}', { email: this.form.email }).then(() => {
                    this.otpSent = true;
                    this.error = null;
                }).catch((error) => {
                    this.error = error.response.data.error;
                });
            },

            submit () {
                if (!this.otpSent) {
                    this.sendOtp();
                } else {
                    axios.post('{{ route('verify_otp') }}', { otp: this.otp, email: this.form.email }).then(() => {
                        axios.post('{{ route('appointments') }}', this.form).then((response) => {
                            window.location = response.data.redirect;
                        }).catch((error) => {
                            console.log(error.response.data);
                            this.error = error.response.data.message;
                        });
                    }).catch(() => {
                        this.error = 'Invalid OTP. Please try again.';
                    });
                }
            }
        }"
        class="space-y-12"
    >
        <div>
            <h2 class="text-lg font-medium mt-3">1. Per quando?</h2>
            <div
                x-data="{
                    picker: null,
                    availableDates: {{ json_encode($availableDates) }}
                }"
                x-init="
                    this.picker = new easepick.create({
                        element: $refs.date,
                        readonly: true,
                        zIndex: 50,
                        date: '{{ $firstAvailableDate }}',
                        css: [
                            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
                            '/vendor/easepick/easepick.css'
                        ],
                        plugins: [
                            'LockPlugin'
                        ],
                        LockPlugin: {
                            minDate: new Date(),
                            filter (date, picked) {
                                return !Object.keys(availableDates).includes(date.format('YYYY-MM-DD'))
                            }
                        },
                        setup (picker) {
                            picker.on('view', (e) => {
                                const { view, date, target } = e.detail;
                                const dateString = date ? date.format('YYYY-MM-DD') : null;

                                if (view === 'CalendarDay' && availableDates[dateString]) {
                                    const span = target.querySelector('.day-slots') || document.createElement('span');
                                    span.className = 'day-slots';
                                    span.innerHTML = pluralize('slot', availableDates[dateString], true);
                                    target.append(span);
                                }
                            });
                        }
                    });

                    this.picker.on('select', (e) => {
                        form.date = new easepick.DateTime(e.detail.date).format('YYYY-MM-DD');
                        $dispatch('slots-requested');
                    });

                    $nextTick(() => {
                        this.picker.trigger('select', { date: '{{ $firstAvailableDate }}' });
                    });
                "
            >
                <input x-ref="date" class="mt-6 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full" placeholder="Choose a date">
            </div>
        </div>

        <div
            x-data="{
                slots: [],
                fetchSlots (event) {
                    axios.get(`{{ route('slots', [$employee, $service]) }}?date=${form.date}`).then((response) => {
                        this.slots = response.data.times;
                    });
                }
            }"
            x-on:slots-requested.window="fetchSlots(event)"
        >
            <h2 class="text-lg font-medium mt-3">2. Scegli un orario</h2>
            <div class="mt-6" x-show="slots.length">
                <div class="grid grid-cols-3 md:grid-cols-5 gap-8 mt-6">
                    <template x-for="slot in slots">
                        <div x-text="slot" class="py-3 px-4 text-sm border border-slate-200 rounded-lg text-center hover:bg-gray-50/75 cursor-pointer" x-on:click="form.time = slot" x-bind:class="{ 'bg-slate-100 hover:bg-slate-100': form.time === slot }"></div>
                    </template>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-medium mt-3">3. I tuoi dati</h2>

            <div x-show="error" x-text="error" x-cloak class="bg-slate-900 text-white py-4 px-6 rounded-lg mt-3"></div>

            <div class="mt-6" x-show="form.time" x-cloak>
                
                <!-- Name field -->
                <div>
                    <label for="name" class="sr-only">Nome Completo</label>
                    <input type="text" name="name" id="name" placeholder="Nome" 
                           class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full"
                           required 
                           x-model="form.name">
                </div>

                <!-- Codice Fiscale field -->
                <div class="mt-3">
                    <label for="codice_fiscale" class="sr-only">Codice fiscale</label>
                    <input type="text" name="codice_fiscale" id="codice_fiscale" 
                           placeholder="Codice fiscale" 
                           class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full"
                           required 
                           x-model="form.codice_fiscale"
                           x-on:input="validateCodiceFiscale">
                    <!-- Display the error message if needed -->
                    <div x-show="errorCodiceFiscale" class="text-red-500 mt-2" x-text="errorCodiceFiscale"></div>
                </div>

                <!-- Email field -->
                <div class="mt-3">
                    <label for="email" class="sr-only">Email </label>
                    <input type="email" name="email" id="email" placeholder="email" 
                           class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full"
                           required 
                           x-model="form.email">
                </div>

                <!-- OTP input field, shown after sending the OTP -->
                <div class="mt-3" x-show="otpSent" x-cloak>
                    <label for="otp" class="sr-only">Entra il OTP</label>
                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" 
                           class="mt-1 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full"
                           x-model="otp"
                           x-bind:required="otpSent"> <!-- Conditionally set required -->
                </div>

                <button type="submit" class="mt-6 py-3 px-6 text-sm border border-slate-200 rounded-lg flex flex-col items-center justify-center text-center hover:bg-slate-900 cursor-pointer bg-slate-800 text-white font-medium">
                    <span x-show="!otpSent">Manda il OTP</span>
                    <span x-show="otpSent" x-cloak>Conferma il OTP</span>
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
