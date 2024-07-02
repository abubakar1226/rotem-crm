class LeadsDatatableController extends DatatableController {
    #leadStatusUrl = null;
    #appointmentsUrl = null;
    #appointmentStatusLabel = null;
    #identifier = null;
    #noResponseStatusLabel = null;

    constructor(
        datatableAjaxUrl, configs, leadStatusUrl, appointmentsUrl, appointmentStatusLabel, identifier,
        noResponseStatusLabel
    ) {
        super(datatableAjaxUrl, configs);
        this.#leadStatusUrl = leadStatusUrl;
        this.#appointmentsUrl = appointmentsUrl;
        this.#appointmentStatusLabel = appointmentStatusLabel;
        this.#identifier = identifier;
        this.#noResponseStatusLabel = noResponseStatusLabel;
    }

    bindEvents() {
        this.initDatatable();
        this.#bindDatatableDrawEvent();
    }

    #bindDatatableDrawEvent() {
        const klass = this;

        klass.datatable.on('draw', () => {
            $('.lead-status-select').on('change', async function (e) {
                klass.#showModalEvent(e.currentTarget);
            });
        });
    }

    #showModalEvent(element) {
        const klass = this;
        const leadStatus = element.value;

        $.ajax({
            url: (klass.#createRecordUrl(leadStatus)).replace(klass.#identifier, $(element).attr('data-id')),
            type: 'GET',
            success: function(data) {
                (new LeadStatusModalController(
                    klass.datatable, 'create-record-form', 'screen-toggle-button',
                    'status-modal', data
                )).bindEvents();
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    }

    #createRecordUrl(leadStatus) {
        if (leadStatus === this.#appointmentStatusLabel)
            return this.#appointmentsUrl;
        else
            return `${this.#leadStatusUrl}?lead_status=${leadStatus}`;
    }
}

window.LeadsDatatableController = LeadsDatatableController;
