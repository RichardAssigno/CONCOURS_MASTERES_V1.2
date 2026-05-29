<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("assets/libs/metismenujs/metismenujs.min.js")}}"></script>
<script src="{{asset("assets/libs/simplebar/simplebar.min.js")}}"></script>
<script src="{{asset("assets/libs/eva-icons/eva.min.js")}}"></script>


<script src="{{asset('assets/js/select2/js/select2.min.js')}}"></script>

<script src="{{asset('assets/js/pages/form-select2.init.js')}}"></script>

<!-- choices js -->
<script src="{{asset("assets/libs/choices.js/public/assets/scripts/choices.min.js")}}"></script>

<!-- color picker js -->
<script src="{{asset("assets/libs/@simonwep/pickr/pickr.min.js")}}"></script>
<script src="{{asset("assets/libs/@simonwep/pickr/pickr.es5.min.js")}}"></script>

<!-- datepicker js -->
<script src="{{asset("assets/libs/flatpickr/flatpickr.min.js")}}"></script>

<!-- init js -->
<script src="{{asset("assets/js/pages/form-advanced.init.js")}}"></script>

<script src="{{asset("assets/js/pages/pass-addon.init.js")}}"></script>

<script src="{{asset("assets/js/pages/eva-icon.init.js")}}"></script>

<!-- Sweet Alerts js -->
<script src="{{asset("assets/libs/sweetalert2/sweetalert2.min.js")}}"></script>

<!-- dropzone plugin -->
<script src="{{asset("assets/libs/dropzone/min/dropzone.min.js")}}"></script>

<!-- Sweet alert init js-->
<script src="{{asset("assets/js/pages/sweet-alerts.init.js")}}"></script>

<script src="{{asset("assets/js/app.js")}}"></script>
<script src="{{asset('assets/libs/block-ui/jquery.blockUI.js')}}"></script>

<!-- blockUI init -->
<script src="{{asset('assets/js/pages/jquery.blockUI.init.js')}}"></script>


<script src="{{asset("assets/js/pages/dashboard.init.js")}}"></script>

<script src="{{asset("assets/js/loader.js")}}"></script>

<script>
    function switchConcoursSession(idSession) {
        if (!idSession) {
            return;
        }

        if (typeof showLoader === 'function') {
            showLoader('Changement de session...');
        }

        $.ajax({
            url: "{{ route('changer.session') }}",
            type: "POST",
            data: {
                idSession: idSession,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (typeof hideLoader === 'function') {
                    hideLoader();
                }

                if (response.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message || 'Session changee',
                            showConfirmButton: false,
                            timer: 1200
                        });
                    }

                    setTimeout(function () {
                        window.location.reload();
                    }, 700);
                }
            },
            error: function () {
                if (typeof hideLoader === 'function') {
                    hideLoader();
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: "Echec",
                        text: "Impossible de changer de session.",
                        icon: "error"
                    });
                }
            }
        });
    }

    $(document).on('change', '.js-session-switcher', function () {
        switchConcoursSession($(this).val());
    });

    $(document).on('click', '.change-session', function (e) {
        e.preventDefault();
        switchConcoursSession($(this).data('id'));
    });
</script>
