class AppointmentsDatatableController extends DatatableController {
    #identifier = null;
    #technicianUpdateUrl = null;

    constructor(datatableAjaxUrl, configs, technicianUpdateUrl, identifier) {
        super(datatableAjaxUrl, configs);
        this.#identifier = identifier;
        this.#technicianUpdateUrl = technicianUpdateUrl;
    }

    bindEvents() {
        this.initDatatable();
        this.#bindDatatableDrawEvent();
    }

    #bindDatatableDrawEvent() {
        const klass = this;
        console.log('I am here');
        this.datatable.on('draw', function () {
            $('.technician-select').on('change', async function (e) {
                if ($(this).val() !== $(this).data('technician-id')) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you want to assign this appointment to another technician?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "rgb(223, 136, 36)",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed)
                            klass.#assignTechnician($(this));
                    });
                }
            });
        });
    }

    #assignTechnician(selectElement) {
        const klass = this;
        const appointmentId = selectElement.data('appointment-id');
        const technicianId = selectElement.val();

        axios.patch(this.#technicianUpdateUrl.replace(klass.#identifier, appointmentId), {
            _token: $('[name="_token"]').val(),
            technician_id: technicianId
        }).then((response) => {
            if (response.data.status === 'success') {
                Swal.fire({
                    title: "Updated",
                    text: response.data.message,
                    icon: response.data.status
                }).then(() => {
                    klass.reloadDatatable();
                });
            }
        });
    }
}

window.AppointmentsDatatableController = AppointmentsDatatableController;
