class RefundsDatatableController extends LeadsDatatableController {
    #updateRefundStatusUrl = null;
    #refundStatusLabel = null;
    #identifier = null;

    constructor(
        refundIndexUrl, configs, leadStatusUrl, appointmentsUrl, appointmentStatusLabel, noResponseStatusLabel,
        updateRefundStatusUrl, refundStatusLabel, identifier
    ) {
        super(
            refundIndexUrl, configs, leadStatusUrl, appointmentsUrl, appointmentStatusLabel, identifier,
            noResponseStatusLabel
        );

        this.#updateRefundStatusUrl = updateRefundStatusUrl;
        this.#refundStatusLabel = refundStatusLabel;
    }

    bindEvents() {
        this.setRowColorOnDataLoad();
        super.bindEvents();
        this.#bindRefundStatusRequestEvent();
    }

    setRowColorOnDataLoad() {
        this.configs.createdRow = async function(row, data){
            $('td', row).addClass($(data['status']).attr('data-row-color'));
        }
    }

    #bindRefundStatusRequestEvent() {
        const klass = this;

        klass.datatable.on('draw', () => {
            $('.refund-status-select').on('change', async function (e) {
                klass.#updateRefundStatusRequest(e.currentTarget);
            });
        });
    }

    #updateRefundStatusRequest(element) {
        const klass = this;

        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to update the refund status?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "rgb(223, 136, 36)",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed)
                klass.#submitUpdateRequest(element)
        });
    }

    #submitUpdateRequest(element) {
        const klass = this;

        $.ajax({
            url: (klass.#updateRefundStatusUrl).replace(klass.#identifier, $(element).attr('data-id')),
            type: 'POST',
            data: {
                _method: 'PATCH',
                _token: $('input[name="_token"]').val(),
                status: element.value
            },
            success: async function(response) {
                await klass.reloadDatatable();

                showNotification(response.status, response.message);
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    }
}

window.RefundsDatatableController = RefundsDatatableController;
