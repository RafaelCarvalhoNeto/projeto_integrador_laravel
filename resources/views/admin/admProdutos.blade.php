@extends('layouts.appAdmin')
@section('title')
    ADM - Produtos
@endsection
@section('content')

    <main class="container pt-3 ajuste" id="barraPedidos">
        @if(session('success'))
        <section class="row">
            <div class="col-12">
                <div class="Message alert alert-success text-center">
                    {{ session('success')}}
                </div>
            </div>
        </section>
        @endif
        <div class="row">
            <h2 class="col-12 p-3 mb-3 border-bottom">Produtos</h2>
            <div class="col-12 mt-3 mb-3">
                <p>Pesquise por um Produto:</p>
                
                <form action="{{ url('/admin/admProdutos/search') }}" method="GET">
                    <div class="input-group col-12 px-0">
                        <input class="form-control border-0" id="inputSearch" type="search" arial-label="search" placeholder="Pesquisar..." name='inputSearch'>
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search-adm" type="submit">Pesquisar</button>
                        </div>
                    </div>
                </form>
                <p class="col-md-4 m-0 mt-3 p-0 ml-auto text-right">Total de resultados encontrados: <strong>{{$found ?? ''}}</strong></p>

                <div id="table"  class="tableAdm">
                    <table class="table table-striped text-center mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <!-- Por alguma razao as paginas Adm nao estao puxando codigo CSS entao inclui style individual em cada imagem -->
                                <th scope="col">ID</th>
                                <th scope="col">Imagem</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Preço (BRL)</th>
                                <th scope="col">Desconto?</th>
                                <th scope="col" colspan="2">Ações</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($produtos as $produto)
                            <tr>
                                <th scope="row">{{ $produto->id }}</td>
                                <td scope="row"><img src="{{ $produto->imagem != null ? asset($produto->imagem) : asset('img/null.png') }}" alt="" width="50" height="50"></td>
                                <td scope="row">{{ $produto->nome }}</td>
                                <td scope="row">{{ $produto->tipo }}</td>        
                                <td scope="row">R$ {{ number_format($produto->preco,2,',','.') }}</td>
                                <td scope="row">
                                    @if ($produto->empromo ==1)
                                        <p class='btn btn-success btn-sm'>Sim</p>
                                    @else
                                    <p class='btn btn-danger btn-sm'>Não</p>
                                    @endif

                                </td>
           
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modalEditarProduto{{ $produto->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Modal Editar -->
                                    <div class="modal fade" id="modalEditarProduto{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">

                                            <div id="carouselModal{{$produto->id}}" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false">
                                                
                                                <div class="carousel-inner">

                                                    <div class="carousel-item active" id="carrosselMessageItem">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Editar o produto ?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form class="container" method="post" action="/admin/admProdutos/update/{{$produto->id}}" enctype="multipart/form-data">
                                                                
                                                                @csrf
                                                                {{ method_field('PUT') }}
                                                                <div class="modal-body">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12 text-left">
                                                                            <label for="inputImagem">Imagem</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="inputImagem" lang="pt" name="imagem">
                                                                                <label class="custom-file-label" for="inputImagem">Escolha o arquivo</label>
                                                                            </div>
                                                                            <input type="hidden" name="imagemName" value="{{$produto->imagem}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12 text-left">
                                                                            <label for="inputProduto">Produto</label>
                                                                            <input type="text" class="form-control" placeholder="Insira o nome do produto"
                                                                            aria-describedby="adicionarProdutoHelp" id="inputProduto" name="inputProduto" value="{{$produto->nome}}"
                                                                            required>
                                                                        </div>
                                                                        <div class="form-group col-md-12 text-center">
                                                                            <label for="inputDescricao">Descrição</label>
                                                                            <input type="text" class="form-control" placeholder="Insira a descrição do produto"
                                                                            aria-describedby="adicionarDescricaoHelp" id="inputDescricao" name="inputDescricao" value="{{$produto->descricao}}"
                                                                            required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4 text-center">
                                                                            <label for="inputCategoria">Categoria</label>
                                                                            <select class="custom-select" name= "inputCategoria">
                                                                                @foreach ($categorias as $categoria)
                                                                                    <option value="{{$categoria->id}}">{{$categoria->tipo}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4 text-center">
                                                                            <label for="inputPreco">Preço</label>
                                                                            <input type="number" class="form-control" placeholder="Preço R$"
                                                                            aria-describedby="adicionarPrecoHelp" id="inputPreco" name="inputPreco"required value="{{$produto->preco}}">
                                                                        </div>
                                                                        <div class="form-group col-md-2 text-center">
                                                                            <label for="inputParcelamento">Parcelas</label>
                                                                            <input type="number" class="form-control" placeholder="N°"
                                                                            aria-describedby="adicionarParcelamentoHelp" id="inputParcelamento" name="inputParcelamento" value="{{$produto->parcelamento}}">
                                                                        </div>
                                                                        <div class="form-group col-md-2 text-center">
                                                                            <label for="titulo1">Garantia</label>
                                                                            <input type="number" class="form-control" placeholder="Ano"
                                                                            aria-describedby="adicionarTitulo1Help" id="inputTecnica1" name="inputTecnica1">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6 text-center">
                                                                            <label for="Titulo2">Marca</label>
                                                                            <input type="text" class="form-control" placeholder="Insira a marca"
                                                                            id="inputTecnica2" name="inputTecnica2">
                                                                        </div>
                                                                        <div class="form-group col-md-6 text-center">
                                                                            <label for="titulo3">Modelo</label>
                                                                            <input type="text" class="form-control" placeholder="Insira o modelo"
                                                                            id="inputTecnica3" name="inputTecnica3">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12 text-center">
                                                                            <label for="Titulo4">Especificações Técnicas</label>
                                                                            <input type="text" class="form-control" placeholder="Especificações..."
                                                                            id="inputTecnica4" name="inputTecnica4">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    @if ($produto->empromo == 1)
                                                                    <a href="#carouselModal{{$produto->id}}" role="button" class="btn btn-danger btn-block" data-slide="next">Retirar da promoção</a>
                                                                    @else
                                                                    <a href="#carouselModal{{$produto->id}}" role="button" class="btn btn-success btn-block" data-slide="next">Colocar em promoção</a>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary btn-block ">Editar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="carousel-item" id="carroselPromoItem">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalSentLabel">Colocar produto em Promo</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                                
                                                            <form action="/admin/admProdutos/promo/{{$produto->id}}" method="post">
                                                                @csrf
                                                                {{ method_field('PUT') }}

                                                                <div class="modal-body">
                                                                    <div class="form-row text-left">
                                                                        <div class="form-group col-md-12">
                                                                            <p>#ID {{$produto->id}} - {{$produto->nome}}</p>
                                                                        </div>                                                                          
                                                                        
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="emPromo">Em promoção?</label>
                                                                            <select class="form-control inputs-promo" name="emPromo" id="emPromo">
                                                                                <option value="0">Não</option>
                                                                                <option value="1">Sim</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="emPromo">Qual o valor do desconto?</label>
                                                                            <input type="text" class="form-control promoDesc inputs-promo" name="promoDesc" onkeyup="fazerCalculo({{$i}})">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="emPromo">Total desconto</label>
                                                                            <p class="dados-promo" id="valorOriginal">R$ {{ number_format($produto->preco,2,',','.') }}</p>
                                                                            <p class="d-none valorOriginalHid">{{ $produto->preco }}</p>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="">Total desconto</label>
                                                                            <p class="dados-promo totalDesconto">R$ 0,00</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="valorDesc">Valor final</label>
                                                                            <p class="valorDesc dados-promo" id="valorDesc">R$ {{ number_format($produto->preco,2,',','.') }}</p>
                                                                            <input type="hidden" class="form-control inputDesconto" name="inputDesconto">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary btn-block">Lançar</button>
                                                                </div>

                                                                
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <a href="/admin/admProdutos" data-toggle="modal" data-target="#modal{{ $produto->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <div class="modal fade" id="modal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Deseja realmente excluir o produto ?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <h3> {{ $produto->nome}}</h3>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>                     
                                                    <form action="/admin/admProdutos/{{ $produto->id }}" method="POST">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <button id="delete-contact" type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp 
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $produtos->appends(['search' => isset($search) ? $search : ''])->links() }}
                    </div>
                </div>


            </div>
        </div>


        <p class="font-weight-bold">Adicionar Produto
            <a href="#" data-toggle="modal" data-target="#modalAdd">
                <i class="far fa-plus-square"></i>
            </a>
        </p>
        
        <!-- Modal Adicionar -->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicione um produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="container" method="post" action="/admin/admProdutos/novo" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('POST') }}
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputImagem">Imagem</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputImagem" lang="pt" name="imagem">
                                        <label class="custom-file-label" for="inputImagem">Escolha o arquivo</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputProduto">Produto</label>
                                    <input type="text" class="form-control" placeholder="Insira o nome do produto"
                                    aria-describedby="adicionarProdutoHelp" id="inputProduto" name="inputProduto"
                                    required>
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <label for="inputDescricao">Descrição</label>
                                    <input type="text" class="form-control" placeholder="Insira a descrição do produto"
                                    aria-describedby="adicionarDescricaoHelp" id="inputDescricao" name="inputDescricao"
                                    required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4 text-center">
                                    
                                    <label for="inputCategoria">Categoria</label>
                                    <select class="custom-select" name= "inputCategoria">
                                        @foreach ($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->tipo}}</option>
                                        
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4 text-center">

                                    <label for="inputPreco">Preço</label>
                                    <input type="number" class="form-control" placeholder="Preço R$"
                                    aria-describedby="adicionarPrecoHelp" id="inputPreco" name="inputPreco"required>
                                </div>
                                <div class="form-group col-md-2 text-center">
                                    
                                    <label for="inputParcelamento">Parcelas</label>
                                    <input type="number" class="form-control" placeholder="N°"
                                    aria-describedby="adicionarParcelamentoHelp" id="inputParcelamento" name="inputParcelamento"required>
                                </div>
                                <div class="form-group col-md-2 text-center">
                                    <label for="titulo1">Garantia</label>
                                    <input type="number" class="form-control" placeholder="Ano"
                                    id="inputTecnica1" name="inputTecnica1">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 text-center">
                                
                                    <label for="Titulo2">Marca</label>
                                    <input type="text" class="form-control" placeholder="Insira a marca do produto"
                                    id="inputTecnica2" name="inputTecnica2">
                                </div>
                                <div class="form-group col-md-6 text-center">
                                    <label for="titulo3">Modelo</label>
                                    <input type="text" class="form-control" placeholder="Insira o modelo do produto"
                                    id="inputTecnica3" name="inputTecnica3">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">

                                    <label for="inputTecnica4">Especificações Técnicas</label>
                                    <input type="text" class="form-control" placeholder="Especificações..."
                                    id="inputTecnica4" name="inputTecnica4">
                                </div>
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

    <script>
        
        function fazerCalculo(i){
           let qtdDesconto = document.querySelectorAll('.promoDesc')[i]
           let valDesconto = document.querySelectorAll('.valorDesc')[i];
           let totDesconto = document.querySelectorAll('.totalDesconto')[i];
           let inpDesconto = document.querySelectorAll('.inputDesconto')[i];
           let valOriginal = Number(document.querySelectorAll('.valorOriginalHid')[i].innerText);

            let qtd = qtdDesconto.value
            let desconto = (valOriginal*(1-qtd/100))
            valDesconto.innerHTML = desconto.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
            totDesconto.innerHTML = (valOriginal - desconto).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
            
            inpDesconto.value = desconto

        }


    </script>

@endsection