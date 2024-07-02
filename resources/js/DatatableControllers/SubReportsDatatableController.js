class SubReportsDatatableController extends DatatableController {
    #subReportUpdateUrl = null;
    #identifier = null;

    constructor(datatableAjaxUrl, configs, subReportUpdateUrl, identifier) {
        super(datatableAjaxUrl, configs);

        this.#subReportUpdateUrl = subReportUpdateUrl;
        this.#identifier = identifier;
    }

    bindEvents() {
        this.initDatatable();
    }

    initOnDrawEvents() {
        this.datatable.on('draw', () => {
            this.#bindEditableAmountInputEvents();
            this.#handleSelectInputChange();
            this.#bindWindowClick();
        });
    }

    #bindEditableAmountInputEvents() {
        const klass = this;

        $('.editable-amount-div').on('click', function (event) {
            event.stopPropagation();
            klass.#handleActiveEditableAmountInput();

            $(this).find('span.editable-amount-amount').addClass('d-none');

            const input = $(this).find('input.editable-amount-input');
            input.attr('disabled', false);
            input.removeClass('d-none');
            input.addClass('active');
            input.val(input.attr('data-value'));
            input.focus();
        });
    }

    #handleActiveEditableAmountInput() {
        const input = $('input.editable-amount-input.active');

        if (input.length && input.val() !== input.attr('data-value')) {
            input.attr('disabled', true);
            input.addClass('d-none');
            input.removeClass('active');

            this.#updateSubReport(input);
        }
    }

    #handleSelectInputChange() {
        const klass = this;

        $('.selectable').on('change', async function (e) {
            klass.#updateSubReport($(this));
        });
    }

    #updateSubReport(input) {
        const klass = this;
        let data = {};
        data[input.attr('data-column')] = input.val();

        $.ajax({
            url: (klass.#subReportUpdateUrl).replace(klass.#identifier, input.attr('data-id')),
            type: 'POST',
            data: {
                _method: 'PATCH',
                _token: $('input[name="_token"]').val(),
                ...data
            },
            success: function(data) {
                klass.reloadDatatable();
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    }

    #bindWindowClick() {
        const klass = this;
        $(window).click('click', function () {
            klass.#handleActiveEditableAmountInput();
        });
    }
}

window.SubReportsDatatableController = SubReportsDatatableController;
