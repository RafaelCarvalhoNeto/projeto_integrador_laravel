@extends('layouts.appAdmin')
@section('content')

    <main class="container pt-3 ajuste" id="barraPedidos">
        @if(isset($success) && $success != "")
            <section class="row">
                <div class="col-12">
                    <div class="message alert alert-success text-center">
                        {{ $success }}
                    </div>
                </div>
            </section>
        @endif
        <div class="row">
            <h2 class="col-12 p-3 mb-3 border-bottom">Usuários</h1>
            <div class="col-12 mt-3 mb-3">
                <p>Pesquise por um Usuário:</p>
                <form action="{{ url('/admin/admUsuarios/search') }}" method="GET">
                    <div class="input-group col-12 px-0">
                        <input class="form-control border-0" id="myInput" type="search" arial-label="search" placeholder="Pesquisar..." name='search'>
                        <div class="input-group-append">
                            <button class="btn btn-primary px-5" type="submit">Pesquisar</button>
                        </div>

                    </div>
                </form>
                <div class="tableAdm">
                    <table class="table table-striped text-center mt-3 tableAdm">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col"> CPF</th>
                            <th scope="col">Email</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">CEP</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">UF</th>
                            <th scope="col" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td scope="row">{{$user->nome}}</td>
                                    <td scope="row">{{$user->sobrenome}}</td>
                                    <td scope="row">{{$user->cpf}}</td>
                                    <td scope="row">{{$user->email}}</td>
                                    <td scope="row">{{$user->endereco}}</td>
                                    <td scope="row">{{$user->cep}}</td>
                                    <td scope="row">{{$user->cidade}}</td>
                                    <td scope="row">{{$user->uf}}</td>
                                    <td scope="row">
                                        <a href="#" data-toggle="modal" data-target="#modalEdit{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="modal fade text-left" id="modalEdit{{ $user->id }}" role="dialog" tabindex="-1"  aria-labelledby="modalEditLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditLabel">Editar usuário #ID{{ $user->id }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="#" method="post">
                                                    @csrf
                                                    {{ method_field('PUT')}} 
                                                        <div class="modal-body">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputNome">Nome</label>
                                                                    <input type="text" class="form-control" id="inputNome" name="inputNome" value="{{$user->nome}}" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputSobrenome">Sobrenome</label>
                                                                    <input type="text" class="form-control" placeholder="Insira seu sobrenome" id="inputSobrenome" name="inputSobrenome" value="{{$user->sobrenome}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputCPF">CPF</label>
                                                                    <input type="number" class="form-control" placeholder="Insira seu CPF"  id="inputCPF" name="inputCPF" value="{{$user->cpf}}" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputRG">RG</label>
                                                                    <input type="number" class="form-control" placeholder="Insira seu RG"  id="inputRG" name="inputRG" value="{{$user->rg}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputEndereco">Endereço</label>
                                                                <input type="text" class="form-control" placeholder="Insira seu endereço"  id="inputEndereco" name="inputEndereco" value="{{$user->endereco}}" required>
                                                            </div>
                                                                
                                                            <div class="form-row">
                                                                <div class="form-group col-md-3">
                                                                    <label for="inputCep">CEP</label>
                                                                    <input type="text" class="form-control" placeholder="01234-567" name="inputCep" value="{{$user->cep}}" required>
                                                                </div>
                                                                <div class="form-group col-md-7">
                                                                    <label for="inputCidade">Cidade</label>
                                                                    <input type="text" class="form-control" placeholder="São Paulo" name="inputCidade" value="{{$user->cidade}}" required>
                                                                </div>
                                                                <div class="form-group col-md-2">
                                                                    <label for="inputUF">UF</label>
                                                                    <select class="form-control" name="inputUF" id="inputUF" required>
                                                                    <option disabled>UF</option>
                                                                    <option value="AC"
                                                                    {{$user->uf=='AC' ? 'selected':''}}
                                                                    >AC</option>
                                                                    <option value="AL"
                                                                    {{$user->uf==('AL') ? 'selected':''}}>AL</option>
                                                                    <option value="AM"
                                                                    {{$user->uf==('AM') ? 'selected':''}}>AM</option>
                                                                    <option value="AP"
                                                                    {{$user->uf==('AP') ? 'selected':''}}>AP</option>
                                                                    <option value="BA"
                                                                    {{$user->uf==('BA') ? 'selected':''}}>BA</option>
                                                                    <option value="CE"
                                                                    {{$user->uf==('CE') ? 'selected':''}}>CE</option>
                                                                    <option value="DF"
                                                                    {{$user->uf==('DF') ? 'selected':''}}>DF</option>
                                                                    <option value="ES"
                                                                    {{$user->uf==('ES') ? 'selected':''}}>ES</option>
                                                                    <option value="GO"
                                                                    {{$user->uf==('GO') ? 'selected':''}}>GO</option>
                                                                    <option value="MA"
                                                                    {{$user->uf==('MA') ? 'selected':''}}>MA</option>
                                                                    <option value="MG"
                                                                    {{$user->uf==('MG') ? 'selected':''}}>MG</option>
                                                                    <option value="MS"
                                                                    {{$user->uf==('MS') ? 'selected':''}}>MS</option>
                                                                    <option value="MT"
                                                                    {{$user->uf==('MT') ? 'selected':''}}>MT</option>
                                                                    <option value="PA"
                                                                    {{$user->uf==('PA') ? 'selected':''}}>PA</option>
                                                                    <option value="PB"
                                                                    {{$user->uf==('PB') ? 'selected':''}}>PB</option>
                                                                    <option value="PE"
                                                                    {{$user->uf==('PE') ? 'selected':''}}>PE</option>
                                                                    <option value="PI"
                                                                    {{$user->uf==('PI') ? 'selected':''}}>PI</option>
                                                                    <option value="PR">PR</option>
                                                                    {{$user->uf==('PR') ? 'selected':''}}
                                                                    <option value="RJ"
                                                                    {{$user->uf==('RJ') ? 'selected':''}}>RJ</option>
                                                                    <option value="RN"
                                                                    {{$user->uf==('RN') ? 'selected':''}}>RN</option>
                                                                    <option value="RO"
                                                                    {{$user->uf==('RO') ? 'selected':''}}>RO</option>
                                                                    <option value="RR"
                                                                    {{$user->uf==('RR') ? 'selected':''}}>RR</option>
                                                                    <option value="RS"
                                                                    {{$user->uf==('RS') ? 'selected':''}}>RS</option>
                                                                    <option value="SC"
                                                                    {{$user->uf==('SC') ? 'selected':''}}>SC</option>
                                                                    <option value="SE"
                                                                    {{$user->uf==('SE') ? 'selected':''}}>SE</option>
                                                                    <option value="SP"
                                                                    {{$user->uf==('SP') ? 'selected':''}}>SP</option>
                                                                    <option value="TO"
                                                                    {{$user->uf==('TO') ? 'selected':''}}>TO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="form-group">
                                                                <label for="inputEmail">Email</label>
                                                                <input type="email" class="form-control" placeholder="Insira seu email"  id="inputEmail" name="inputEmail" value="{{$user->email}}" required>
                                                            </div>
                                                    
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputSenha">Senha</label>
                                                                    <input type="password" name="inputSenha" class="form-control{{$errors->has('inputSenha') ? ' is-invalid':''}}" placeholder="Senha" aria-describedby="senhaHelp" id="inputSenha">
                                                                    <div class="invalid-feedback">{{ $errors->first('inputSenha') }}</div> 
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="inputConfirma">Confirma Senha</label>
                                                                    <input type="password" class="form-control{{$errors->has('inputConfirma') ? ' is-invalid':''}}" placeholder="Confirma senha" aria-describedby="ConfirmaHelp" id="inputConfirma" name="inputConfirma">
                                                                    <div class="invalid-feedback">{{ $errors->first('inputConfirma') }}</div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark btn-block">Editar</a>
                                                        </div>
                                                    </form>
                                
                                                </div>

                                            </div>
                                        </div>
                                    </td>


                                    <td scope="row">
                                        <a href="#" data-toggle="modal" data-target="#modal{{ $user->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <div class="modal fade" id="modal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Deseja excluir o usuario?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <p>ID: {{ $user->id }}</p>
                                                        <p>Nome: {{ $user->nome }}</p>
                                                        <p>Sobrenome: {{ $user->sobrenome }}</p>
                                                        <p>Email: {{ $user->email }}</p>
                                                    </div>
                                                    <div class="modal-footer">

                                                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> --}}
                                                        <form class="btn-block"action="/admin/remove/{{ $user->id }}" method="POST">
                                                            @csrf
                                                            {{ method_field('DELETE') }}
                                                            <button id="delete-contact" type="submit" class="btn btn-danger btn-block">Excluir</a>

                                                        </form>
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->appends(['search' => isset($search) ? $search : ''])->links() }}
                </div>


            </div>
        </div>

    </main>

@endsection