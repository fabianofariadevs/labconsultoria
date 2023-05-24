$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    var url = $('table').attr('url');

    $.extend($.fn.dataTable.defaults, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/pt-BR.json'
        },
        initComplete: function (settings, json) {
            $('[tooltip="tooltip"]').tooltip( );
        }
    });

    $('#tabelaCategorias').DataTable({
        paging: false,
        columnDefs: [
            {
                targets: [-1, -2],
                orderable: false
            }
        ],
        order: [[1, 'asc']]
    });
    $('#tabelaPosts').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/posts/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[1]) {
                        return '<a data-fancybox data-caption="Capa" class="overflow zoom" href="' + url + 'uploads/imagens/' + row[1] + '"><img src=" ' + url + 'uploads/imagens/thumbs/' + row[1] + ' " /></a>';
                    } else {
                        return '<i class="fa-regular fa-images fs-1 text-secondary"></i>';
                    }
                }
            },
            null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[5] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + 'admin/posts/status/' + row[0] + ' " tooltip="tooltip" title="Status"><i class="fa fa-child" aria-hidden="true"></i></a> ';

                    html += ' <a href=" ' + url + 'admin/posts/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/posts/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [2]
            },
            {
                className: 'dt-center',
                targets: [0, 1, 3, 4, 5, 6]
            },
            {
                orderable: false,
                targets: [1, -1]
            }
        ]
    });
    //TABELA USUÁRIOS
    $('#tabelaUsuarios').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/usuarios/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[3] === 3) {
                        return '<span class="text-danger">Administrador</span>';
                    } else {
                        return '<span class="text-secondary">Usuário</span>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (row[4] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + 'admin/usuarios/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/usuarios/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [1, 2]
            },
            {
                className: 'dt-center',
                targets: [3, 4, 5]
            },
            {
                orderable: false,
                targets: [-1]
            }
        ]
    });
    //TABELA CLIENTES
    $('#tabelaClientes').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/clientes/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null, null, null, null, null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[7] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + 'admin/clientes/status/' + row[0] + ' " tooltip="tooltip" title="Status"><i class="fa fa-child" aria-hidden="true"></i></a> ';

                    html += ' <a href=" ' + url + 'admin/clientes/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';
                    html += '<a href=" ' + url + 'admin/clientes/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';
                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [1, 2]
            },
            {
                className: 'dt-center',
                targets: [3, 4, 5, 6, 7, 8]
            },
            {
                orderable: false,
                targets: [1, -1]
            }
        ]
    });
//TABELA FORNECEDOR
    $('#tabelaFornecedor').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/fornecedor/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null, null, null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[5] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';
                    html += ' <a href=" ' + url + 'admin/fornecedor/status/' + row[0] + ' " tooltip="tooltip" title="Status"><i class="fa fa-child" aria-hidden="true"></i></a> ';

                    html += ' <a href=" ' + url + 'admin/fornecedor/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/fornecedor/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [1, 2]
            },
            {
                className: 'dt-center',
                targets: [0, 3, 4, 5, 6]
            },
            {
                orderable: false,
                targets: [-1]
            }
        ]
    });
    //TABELA MIX_PRODUTO
    $('#tabelamixProdutos').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/mixProdutos/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null, null, null, null, null, null, null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[9] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + 'admin/mixProdutos/status/' + row[0] + ' " tooltip="tooltip" title="Status"><i class="fa fa-child" aria-hidden="true"></i></a> ';

                    html += ' <a href=" ' + url + 'admin/mixProdutos/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/mixProdutos/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [1, 2]
            },
            {
                className: 'dt-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9, 10]
            },
            {
                orderable: false,
                targets: [1, -1]
            }
        ]
    });

//TABELA RECEITAS
    $('#tabelaReceitas').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/receitas/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },

        columns: [
            null, null, null, null, null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[7] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + 'admin/receitas/status/' + row[0] + ' " tooltip="tooltip" title="Status"><i class="fa fa-child" aria-hidden="true"></i></a> ';
                    html += ' <a href=" ' + url + 'admin/receitas/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/receitas/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [0, 1, 2]
            },
            {
                className: 'dt-center',
                targets: [3, 4, 5, 6, 7, 8]
            },
            {
                orderable: false,
                targets: [1, -1]
            }
        ]
    });

//TABELA PRODUCAO
    $('#tabelaProducao').DataTable({
        order: [[0, 'desc']],
        processing: true,
        serverSide: true,
        ajax: {
            url: url + 'admin/producao/datatable',
            type: 'POST',
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        },
        columns: [
            null, null, null, null, null, null, null,
            {
                data: null,
                render: function (data, type, row) {
                    if (row[7] === 1) {
                        return '<i class="fa-solid fa-circle text-success" tooltip="tooltip" title="Ativo"></i>';
                    } else {
                        return '<i class="fa-solid fa-circle text-danger" tooltip="tooltip" title="Inativo"></i>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '';

                    html += ' <a href=" ' + url + row[0] + ' "data-bs-toggle="offcanvas" tooltip="tooltip" title="Status"><i class="fa-solid fa-arrow-trend-up"></i></a> ';
                    html += ' <a href=" ' + url + 'admin/producao/editar/' + row[0] + ' " tooltip="tooltip" title="Editar"><i class="fa-solid fa-pen m-1"></i></a> ';

                    html += '<a href=" ' + url + 'admin/producao/deletar/' + row[0] + ' "><i class="fa-solid fa-trash m-1" tooltip="tooltip" title="Deletar"></i></a>';

                    return html;
                }
            }
        ],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: [1, 2]
            },
            {
                className: 'dt-center',
                targets: [3, 4, 5, 6, 7, 8]
            },
            {
                orderable: false,
                targets: [1, -1]
            }
        ]
    });



});