@extends('adminlte::page')

@section('title', 'Pessoas')

@section('content_header')
    <div class="row">
        <div class="container">
            <div class="row">
                <h1>Pessoas</h1>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCriar">Cadastrar
                        Pessoa</button>
                </div>
            </div>
        </div>

    @stop

    @section('content')

        <div class="container-fluid mt-5">
            <div class="card p-1">
                <div class="tools">
                    <div class="circle">
                        <span class="red box"></span>
                    </div>
                    <div class="circle">
                        <span class="yellow box"></span>
                    </div>
                    <div class="circle">
                        <span class="green box"></span>
                    </div>
                </div>
                <div class="card__content">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success mt-2">{{ Session::get('success') }}
                        </div>
                    @endif

                    <table id='tabela' class="table table-striped table-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th class="col-3">Nome</th>
                                <th class="col-2">CPF</th>
                                <th class="col-3">Endereço</th>
                                <th class="col-2">Editar</th>
                                <th class="col-2">Remover</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pessoas as $pessoa)
                                <tr>
                                    <td>{{ $pessoa->nome }}</td>
                                    <td>{{ $pessoa->cpf }}</a></td>
                                    <td>{{ $pessoa->endereco }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-detail open_edit" data-id="{{ $pessoa->id }}"
                                            data-toggle="modal" data-target="#modalEditar">Editar</button>
                                    </td>
                                    <td>
                                        <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Tem certeza que deseja deletar?')"
                                                type="submit">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Criar --}}
        <form method="post" action="{{ route('pessoas.store') }}">
            <div class="modal" tabindex="-1" id="modalCriar" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cadastrar Pessoa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">

                                @csrf

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="nome">Nome:</label>
                                        <input type="text" id="createNome" class="form-control" name="nome" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="cpf">CPF:</label>
                                        <input type="text" class="form-control" id="inputCpf" name="cpf"
                                            data-mask="000.000.000-00" data-mask-reverse="true" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="endereco">Endereço:</label>
                                        <input type="text" class="form-control" name="endereco" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="save" class="btn btn-primary">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal Editar --}}
        <form method="post" action="{{ route('pessoas.update') }}">
            @csrf
            <div class="modal" tabindex="-1" id="modalEditar" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="hidden" id="pessoa_id" name="pessoa_id" value="">
                            <h5 class="modal-title">Editar Pessoa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="nome">Nome:</label>
                                        <input type="text" id="editNome" class="form-control editNome"
                                            name="nome" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="cpf">CPF:</label>
                                        <input type="text" class="form-control editCpf" id="inputCpf" name="cpf"
                                            data-mask="000.000.000-00" data-mask-reverse="true" />
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="endereco">Endereço:</label>
                                        <input type="text" class="form-control editEndereco" name="endereco" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitEdit" name="edit"
                                class="btn btn-primary">Editar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
        <style>
            .card {
                width: auto;
                height: auto;
                margin: 0 auto;
                background-color: #011522;
                border-radius: 8px;
                z-index: 1;
                background: rgba(255, 255, 255, 0.25);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            .tools {
                display: flex;
                align-items: center;
                padding: 9px;
            }

            .circle {
                padding: 0 4px;
            }

            .box {
                display: inline-block;
                align-items: center;
                width: 10px;
                height: 10px;
                padding: 1px;
                border-radius: 50%;
            }

            .red {
                background-color: #ff605c;
            }

            .yellow {
                background-color: #ffbd44;
            }

            .green {
                background-color: #00ca4e;
            }
        </style>
    @stop

    @section('js')
        <script>
            $(document).ready(function() {

                function capitalizeFirstLetter(str) {
                    var splitStr = str.toLowerCase().split(' ');
                    for (var i = 0; i < splitStr.length; i++) {
                        // You do not need to check if i is larger than splitStr length, as your for does that for you
                        // Assign it back to the array
                        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
                    }
                    // Directly return the joined string
                    return splitStr.join(' ');
                }


                $("#createNome").keyup(function() {
                    $(this).val(capitalizeFirstLetter($(this).val()));
                });

                $("#editNome").keyup(function() {
                    $(this).val(capitalizeFirstLetter($(this).val()));
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.open_edit').on('click', function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    $.get('pessoas/' + id + '/edit', function(data) {
                        cpf = data.cpf;
                        cpf = cpf.replace(/\D/g, "");
                        cpf = cpf.replace(/^(\d{3})/g, "$1.");
                        cpf = cpf.replace(/(\d{3})(\d{3})/g, "$1.$2-");
                        $('#pessoa_id').val(data.id);
                        $('.editNome').val(data.nome);
                        $('.editCpf').val(cpf);
                        $('.editEndereco').val(data.endereco);
                    })
                });

                $(function() {
                    $('#createNome').keydown(function(e) {
                        if (e.shiftKey || e.ctrlKey || e.altKey) {
                            e.preventDefault();
                        } else {
                            var key = e.keyCode;
                            if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <=
                                    40) || (key >= 65 && key <= 90))) {
                                e.preventDefault();
                            }
                        }
                    });

                    $('#editNome').keydown(function(e) {
                        if (e.shiftKey || e.ctrlKey || e.altKey) {
                            e.preventDefault();
                        } else {
                            var key = e.keyCode;
                            if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <=
                                    40) || (key >= 65 && key <= 90))) {
                                e.preventDefault();
                            }
                        }
                    });
                });

            });
        </script>
    @stop
