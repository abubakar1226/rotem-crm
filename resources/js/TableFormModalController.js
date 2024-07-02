class TableFormModalController {
    #form = null;
    #modal = null;
    #modalHTMl = null;

    constructor(formId, modal, modalHTMl) {
        this.#form = formId;
        this.#modal = modal;
        this.#modalHTMl = modalHTMl;
    }

    bindEvents() {
        this.#showModal();
        this.#initSortable();
        submitAjaxPostForm(this.#form, this.#modal, (configs) => {
            datatableController.configs = configs;
            datatableController.datatable.clear().destroy();
            datatableController.initDatatable();
        });
    }

    #initSortable() {
        const columns = $("#sortable").sortable({
            update: function (event, ui) {
                // Reorder the positions
                $("#sortable li").each(function (index) {
                    $(this).find("input.position").val(index + 1);
                });
            }
        });

        columns.disableSelection();
    }

    #showModal() {
        this.#modal.html(this.#modalHTMl);
        this.#modal.modal('show');
        this.#form = $(`#${this.#form}`);
    }
}

window.TableFormModalController = TableFormModalController;
