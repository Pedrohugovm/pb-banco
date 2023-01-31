@extends('adminlte::page')

@section('title', 'Movimentações')

@section('content_header')
    <div class="row">
        <div class="container">
            <div class="row">
                <h1>Movimentações e Extratos</h1>
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

                    <form method="post" data-action="{{ route('movimentacoes.store') }}" id="createForm">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-12">
                                <label for="nome">Pessoa:</label>
                                <select class="form-control select2" aria-label=".form-select-lg example" id="inputPessoa"
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
                                <label for="conta_id">Número da conta:</label>
                                <select class="form-control select2" aria-label=".form-select-lg example" id="inputConta"
                                    name="conta_id">
                                    <option selected value="">Selecione a conta</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="valor">Valor:</label>
                                <input type="text" data-mask="000.000,00" data-mask-reverse="true" id="inputValor"
                                    class="form-control" name="valor" />
                            </div>

                            <div class="form-group col-12">
                                <label for="mov_tipo">Depositar/Retirar:</label>
                                <select class="form-control select2" aria-label=".form-select-lg example" name="mov_tipo">
                                    <option selected value="">Selecione o tipo</option>
                                    <option value="1">Depositar</option>
                                    <option value="2">Retirar</option>
                                </select>
                            </div>


                        </div>
                        <div class="row p-3">
                            <div class="ml-auto">
                                <button type="submit" name="save" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>

                        <div class="alert alert-danger d-none" id="errors">
                        </div>
                    </form>

                </div>
            </div>
        </div>

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

                    <div class="ml-2">
                        <h1>Extratos</h1>
                    </div>
                    <table id='tabela' class="table table-striped" style="width:100%; overflow-x:auto;">
                        <thead>
                            <tr>
                                <th class="col-3">Data</th>
                                <th class="col-2">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="tableData"></td>
                                <td id="tableValor"></a></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="ml-2" id="hide-saldo"></p>

                </div>
            </div>
        </div>

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

                // Ao selecionar uma pessoa, pega as contas dela e cria as opções no select de contas
                $('#inputPessoa').on('change', function(event) {
                    var id = $(this).find(":selected").val();
                    var selHTML = '';

                    $.get('movimentacoes/' + id + '/atualizaSelect', function(data) {

                        $.each(data, function(i, item) {
                            $('#inputConta').find('option').not(':first').remove();
                            $('#inputConta').append($('<option>', {
                                value: item.id,
                                text: item.num_conta + ' - Saldo: R$ ' + item.saldo
                            }));
                            $("#hide-saldo").text('Saldo: ' + item.saldo);

                        });
                    });
                });

                // Ao selecionar uma conta, monta a tabela de extratos desta conta
                $('#inputConta').on('change', function(event) {
                    var id = $(this).find(":selected").val();
                    var trHTML = '';

                    $.get('movimentacoes/' + id + '/atualizaTabela', function(data) {
                        trHTML += '<tr><th>' + 'Data' + '</th><th>' + 'Valor' + '</th>';
                        $.each(data, function(i, item) {

                            if (parseInt(item.valor, 10) < 0) {
                                trHTML += '<tr><td>' + item.data +
                                    '</td><td class="text-danger">' + item.valor +
                                    '</tr>';
                            } else {
                                trHTML += '<tr><td>' + item.data + '</td><td>' + item.valor +
                                    '</tr>';
                            }
                        });
                        $('#tabela').html(trHTML);
                    });
                });

                // Cria nova movimentação, limpa os inputs, atualiza a tabela de extratos e atualiza o select de conta
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
                            $("#inputConta").trigger("change");
                            $("#inputValor").val("");
                            // $('#inputConta').html('');
                            $("#inputPessoa").trigger("change");
                        },
                        error: function(response) {
                            var err = JSON.parse(response.responseText);
                            $('#errors').text(err.message);
                            $('#errors').removeClass('d-none');
                            $("#inputConta").trigger("change");
                            $("#inputValor").val("");
                            // $('#inputConta').html('');
                            $("#inputPessoa").trigger("change");
                            // setTimeout(function() {

                            //     location.reload()

                            // }, 2500);
                        }
                    });

                });

            });
        </script>
    @stop
