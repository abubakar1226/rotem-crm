class LeadStatusModalController {
    #leadsTable = null;
    #form = null;
    #screenToggleButton = null;
    #modal = null;
    #response = null;

    constructor(leadsTable, formId, screenToggleButtonId, modal, response) {
        this.#modal = $(`#${modal}`);
        this.#response = response;

        this.#showModal();

        this.#leadsTable = leadsTable;
        this.#form = $(`#${formId}`);
        this.#screenToggleButton = $(`#${screenToggleButtonId}`);
    }

    bindEvents() {
        this.#modalHideEvent();
        this.#toggleScreen();
        this.#submit();
    }

    #showModal() {
        this.#modal.html(this.#response);
        this.#modal.modal('show');
    }

    #modalHideEvent() {
        this.#modal.on('hidden.bs.modal', async () => {
            await this.#leadsTable.ajax.reload();
        });
    }

    #toggleScreen() {
        if (this.#screenToggleButton !== null) {
            this.#screenToggleButton.on('click', () => {
                const currentScreen = this.#screenToggleButton.attr('data-screen');
                const nextScreen = currentScreen === 'main' ? 'message' : 'main';

                this.#form.find(`div.screen[data-screen="${currentScreen}"]`).hide();
                this.#form.find(`div.screen[data-screen="${nextScreen}"]`).show();

                this.#screenToggleButton.attr('data-screen', nextScreen);
                this.#screenToggleButton.text(currentScreen === 'main' ? 'Back' : 'Next');
            });
        }
    }

    #submit() {
        const klass = this;
        const form = this.#form;
        console.log(this.#form);

        if (form !== null) {
            form.on('submit', (e) => {
                e.preventDefault();

                const data = form.serializeArray();
                $.ajax({
                    url: form.prop('action'),
                    data: data,
                    type: 'POST',
                    success: async (response) => {
                        klass.#modal.modal('hide');

                        showNotification(response.status, response.message);
                    },
                    error: (xhr, status, error) => {
                        if (xhr.status === 422)
                            showValidationErrors(form, xhr.responseJSON.errors)
                        console.error(xhr, status, error);
                    }
                });
            });
        }
    }
}

window.LeadStatusModalController = LeadStatusModalController;
