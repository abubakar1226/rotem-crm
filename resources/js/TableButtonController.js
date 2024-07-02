class TableButtonController {
    #button = null;
    #formId = null;
    #modal = null;

    constructor(buttonId, formId, modalId) {
        this.#button = $(`#${buttonId}`);
        this.#modal = $(`#${modalId}`);
        this.#formId = formId;
    }

    bindEvents() {
        this.#initOpenModal();
    }

    #initOpenModal() {
        const klass = this;

        klass.#button.on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: klass.#button.attr('data-url'),
                type: 'GET',
                success: async (response) => {
                    (new TableFormModalController(klass.#formId, klass.#modal, response)).bindEvents();
                },
                error: (xhr, status, error) => {
                    console.error(xhr, status, error);
                }
            });
        })
    }
}

window.TableButtonController = TableButtonController;
