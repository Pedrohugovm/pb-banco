@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
    <div class="row">
        <div class="container">
            <div class="row">
                <h1>Contas</h1>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCriar">Cadastrar
                        Conta</button>
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

                    @if (Session::has('error'))
                        <div class="alert alert-danger mt-2">{{ Session::get('error') }}
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success mt-2">{{ Session::get('success') }}
                        </div>
                    @endif

                    <table id='tabela' class="table table-striped" style="width:100%; overflow-x:auto;">
                        <thead>
                            <tr>
                                <th class="col-3">Nome</th>
                                <th class="col-2">CPF</th>
                                <th class="col-3">Número da conta</th>
                                <th class="col-2">Editar</th>
                                <th class="col-2">Remover</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contas as $conta)
                                <tr>
                                    <td>{{ $conta->pessoas->nome }}</td>
                                    <td>{{ $conta->pessoas->cpf }}</a></td>
                                    <td>{{ $conta->num_conta }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-detail open_edit" data-id="{{ $conta->id }}"
                                            data-toggle="modal" data-target="#modalEditar">Editar</button>
                                    </td>
                                    <td>
                                        <form action="{{ route('contas.destroy', $conta->id) }}" method="post">
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
        <form method="post" data-action="{{ route('contas.store') }}" id="createForm">
            @csrf
            <div class="modal" tabindex="-1" id="modalCriar" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cadastrar Conta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="nome">Pessoa:</label>
                                        <select class="form-control select2" aria-label=".form-select-lg example"
                                            name="pessoa_id">
                                            <option selected value="">Selecione a pessoa</option>
                                            @foreach ($pessoas as $pessoa)
                                                <option value="{{ $pessoa->id }}">
                                                    {{ $pessoa->nome . ' - ' . $pessoa->cpf }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="num_conta">Número da conta:</label>
                                        <input type="number" data-mask="0000000000" class="form-control"
                                            name="num_conta" />
                                    </div>
                                </div>

                                <div class="alert alert-danger d-none" id="errors">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="save" class="btn btn-primary">Salvar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal Editar --}}
        <form method="post" action="{{ route('contas.update') }}">
            @csrf
            <div class="modal" tabindex="-1" id="modalEditar" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="hidden" id="conta_id" name="conta_id" value="">
                            <h5 class="modal-title">Editar conta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="nome">Pessoa:</label>
                                        <select class="form-control select2" id="editPessoa" aria-label=".form-select-lg example"
                                            name="pessoa_id">
                                            <option selected value="">Selecione a pessoa</option>
                                            @foreach ($pessoas as $pessoa)
                                                <option value="{{ $pessoa->id }}">
                                                    {{ $pessoa->nome . ' - ' . $pessoa->cpf }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="num_conta">Número da conta:</label>
                                        <input type="number" id="editNumConta" data-mask="0000000000" class="form-control"
                                            name="num_conta" />
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#createForm').on('submit', function(event) {
                    event.preventDefault();

                    var url = $(this).attr('data-action');
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            location.reload();
                        },
                        error: function(response) {
                            var err = JSON.parse(response.responseText);
                            $('#errors').text(err.message);
                            $('#errors').removeClass('d-none');
                        }
                    });

                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.open_edit').on('click', function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    $.get('contas/' + id + '/edit', function(data) {
                        console.table(data);
                        $('#conta_id').val(data.id);
                        $('#editPessoa').val(data.pessoa_id);
                        $('#editNumConta').val(data.num_conta);
                    })
                });

            });
        </script>
    @stop
