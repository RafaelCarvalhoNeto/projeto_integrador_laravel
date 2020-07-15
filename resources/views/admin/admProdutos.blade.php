@extends('layouts.appAdmin')
@section('content')


    <main class="container pt-3 ajuste" id="barraPedidos">
        <div class="row">
            
            <h2 class="col-12 p-3 mb-3 border-bottom">Produtos</h2>
            <div class="col-12 mt-3 mb-3">
                <p>Pesquise por uma Produto:</p>
                <form action="#" method="GET">
                    <div class="input-group col-12 px-0">
                        <input class="form-control border-0" id="myInput" type="search" arial-label="search" placeholder="Pesquisar..." name='search'>
                        <div class="input-group-append">

                            <button class="btn btn-primary px-5" type="submit">Pesquisar</button>

                        </div>

                    </div>
                </form>
                <div id="table"  class="tableAdm">
                    <table class="table table-striped text-center mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <!-- Por alguma razao as paginas Adm nao estao puxando codigo CSS entao inclui style individual em cada imagem -->
                                <th scope="col">ID</th>
                                <th scope="col">Imagem</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Preço (BRL)</th>
                                <th scope="col">Categoria</th>
                                <th scope="col" colspan="2">Ações</th>
            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                            <tr>
                                <td scope="row">{{ $produto->id }}</td>

                                <td scope="row"><img src="{{ $produto->imagem != null ? asset($produto->imagem) : asset('img/null.png') }}" alt="" width="50" height="50"></td>

                                <td scope="row">{{ $produto->nome }}</td>
                                <td scope="row">R$ {{ number_format($produto->preco,2) }}</td>
                                <td scope="row">{{ $produto->tipo }}</td>                   
                                <td>
                                    <a href="#">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modal">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Deseja realmente excluir?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Computador</h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <a href="Bolsas">
                        
                                                <form action="/admin/admProdutos/{{ $produto->id }}" method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button id="delete-contact" type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                        
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                                
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                

            </div>
        </div>

            <!-- Modal Excluir -->


        <p class="font-weight-bold">Adicionar Produto
            <a href="#" data-toggle="modal" data-target="#modalAdd">
                <i class="far fa-plus-square"></i>
            </a>
        </p>
        <div class="d-flex justify-content-center mt-4">
            {{ $produtos->appends(['search'=>isset($search) ? $search:''])->links() }}
        </div>


        <!-- Modal Adicionar -->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicione um produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <form class="container" method="post" action="/admin/admProdutos/novo" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputImagem">Imagem</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputImagem" lang="pt" name="imagem">
                                <label class="custom-file-label" for="inputImagem">Escolha o arquivo</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputProduto">Produto</label>
                            <input type="text" class="form-control" placeholder="Insira o nome do produto"
                            aria-describedby="adicionarProdutoHelp" id="inputProduto" name="inputProduto"
                            required>
                        </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCategoria">Categoria</label>

                                <select class="custom-select" name= "inputCategoria">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">

                                <label for="inputPreco">Preço</label>
                                <input type="number" class="form-control" placeholder="Insira o preço do produto"
                                aria-describedby="adicionarPrecoHelp" id="inputPreco" name="inputPreco"required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputDescricao">Descrição</label>
                                <input type="text" class="form-control" placeholder="Insira a descrição do produto"
                                aria-describedby="adicionarDescricaoHelp" id="inputDescricao" name="inputDescricao"
                                required>
                            </div>
                            <div class="form-group col-md-6">

                                <label for="inputParcelamento">Parcelamento</label>
                                <input type="number" class="form-control" placeholder="Insira o preço do produto"
                                aria-describedby="adicionarParcelamentoHelp" id="inputParcelamento" name="inputParcelamento"required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="titulo1">Titulo</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="titulo1" name="titulo1">
                            </div>
                            <div class="form-group col-md-6">

                                <label for="inputTecnica1">Info</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="inputTecnica1" name="inputTecnica1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="titulo2">Titulo</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="titulo2" name="titulo2">
                            </div>
                            <div class="form-group col-md-6">

                                <label for="inputTecnica2">Info</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="inputTecnica2" name="inputTecnica2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="titulo3">Titulo</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="titulo3" name="titulo3">
                            </div>
                            <div class="form-group col-md-6">

                                <label for="inputTecnica3">Info</label>
                                <input type="text" class="form-control" placeholder="Insira o preço do produto"
                                id="inputTecnica3" name="inputTecnica3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Adicionar</button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>


@endsection