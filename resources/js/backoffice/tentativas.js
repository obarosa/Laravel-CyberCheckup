const DataTable = require("datatables.net");

//datatable para Utilizadores
$(document).ready(function () {
    $('#tableTentativas').DataTable({
        searching: true,
        ordering: false,
        select: false,
        paging: true,
        pageLength: 15,
        info: false,
        lengthChange: false,
        oLanguage: {
            sSearch: "Pesquisar:"
        },
        language: {
            paginate: {
                'previous': '<i class="fa fa-arrow-left"></i>',
                'next': '<i class="fa fa-arrow-right"></i>'
            },
            emptyTable: "Não existem registos",
        },
        initComplete: function () {
            this.api()
                .columns([2, 3])
                .every(function (d) {
                    var column = this;
                    var theadname = $("#tableTentativas th").eq([d]).text(); //used this specify table name and head
                    var select = $('<select class="form-control my-1 fw-bold"><option value="">' + theadname + '</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });
        },
    });
});
