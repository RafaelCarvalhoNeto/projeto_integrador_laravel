<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProdutosController extends Controller
{
    public function index() {

        if(Auth::user('admin')===1){
            return redirect()->route('admin.login');
        }
            $produtos = DB::table('produtos')
            ->leftjoin('categorias', 'produtos.categoria','=', 'categorias.id')
            ->select('produtos.nome', 'produtos.imagem', 'produtos.preco', 'produtos.id','categorias.tipo',
            'produtos.descricao', 'produtos.parcelamento');
            $categorias = Categoria::All();
            $found = $produtos->count();
            $produtos = $produtos->paginate(10);
                
            if($produtos){
                return view('admin.admProdutos')->with(['produtos'=> $produtos,'found'=> $found, 'categorias'=> $categorias]);
            }
        }

    public function create(Request $request) {
         
        $imagem = $request->file('imagem');
        
        if(empty($imagem)){
            $pathRelative = null;
        } else{
            $imagem->storePublicly('uploads');
            
            $absolutePath = public_path()."/storage/uploads";

            $name = $imagem->getClientOriginalName();

            $imagem->move($absolutePath, $name);

            $pathRelative = "storage/uploads/$name";
        }

        $produto = new Produto;

        $produto->nome = $request->inputProduto;
        $produto->imagem = $pathRelative;
        $produto->categoria = $request->inputCategoria;
        $produto->preco  = $request->inputPreco;
        $produto->descricao = $request->inputDescricao;
        $produto->parcelamento = $request->inputParcelamento;

        $informacoes  = [
            $request->titulo1 => $request->inputTecnica1,
            $request->titulo2 => $request->inputTecnica2,
            $request->titulo3 => $request->inputTecnica3,
            $request->titulo4 => $request->inputTecnica4
        ];

        $arrayinfos = json_encode($informacoes);

        $produto->informacoes = $arrayinfos;
        

        $produto->save();

        if($produto){
            return redirect()->route('admin.admProdutos')->with('success','Produto criado com sucesso!');
        }
        return redirect()->route('admin.admProdutos')->with('success', 'Produto criado com sucesso!');
    } 

    public function update(Request $request, $id){
        $produto = Produto::find($id);
        $imagem = $request->file('imagem');
        
        if(empty($imagem)){
            $pathRelative = $request->imagemName;
        } else{
            $imagem->storePublicly('uploads');
            
            $absolutePath = public_path()."/storage/uploads";

            $name = $imagem->getClientOriginalName();

            $imagem->move($absolutePath, $name);

            $pathRelative = "storage/uploads/$name";
        }

        $produto->nome = $request->inputProduto;
        $produto->imagem = $pathRelative;
        $produto->categoria = $request->inputCategoria;
        $produto->preco  = $request->inputPreco;
        $produto->descricao = $request->inputDescricao;
        $produto->parcelamento = $request->inputParcelamento;

        $informacoes  = [
            $request->titulo1 => $request->inputTecnica1,
            $request->titulo2 => $request->inputTecnica2,
            $request->titulo3 => $request->inputTecnica3,
            $request->titulo4 => $request->inputTecnica4
        ];

        $arrayinfos = json_encode($informacoes);

        $produto->informacoes = $arrayinfos;
        
        $produto->update();
        
        if($produto){
        $produtos = DB::table('produtos')
        ->leftjoin('categorias', 'produtos.categoria','=', 'categorias.id')
        ->select('produtos.nome', 'produtos.imagem', 'produtos.preco', 'produtos.id','categorias.tipo', 'produtos.descricao', 'produtos.parcelamento')
        ->paginate(10);
        $categorias = Categoria::All();

            return redirect()->route('admin.admProdutos')->with(['produtos'=> $produtos,'categorias'=>$categorias,
                'success'=> 'Produto alterado com sucesso!' ]);

        }
    }

    public function delete($id){
        
        $produto = Produto::find($id);

        if($produto->delete()){

            $produtos = Produto::paginate(10);
            $categorias = Categoria::All();

            if($produtos){
            return redirect()->route('admin.admProdutos')->with(['produtos' => $produtos, 'categorias'=> $categorias,
                'success' => 'Produto excluído com sucesso']);

            }
            
        }
    }
    
    public function search(Request $request){

        $search = $request->input('inputSearch');

        $produtos = DB::table('produtos')
        ->leftjoin('categorias', 'produtos.categoria','=', 'categorias.id')
        ->select('produtos.nome', 'produtos.imagem', 'produtos.preco', 'produtos.id','categorias.tipo', 'produtos.parcelamento', 'produtos.descricao')
        ->where('produtos.nome', 'like' , '%'. $search . '%')
        ->orWhere('categorias.tipo', 'like' , '%'. $search . '%');
        $categorias = Categoria::All();
        $found = $produtos->count();
        $produtos = $produtos->paginate(10);

        return view('admin.admProdutos')->with([
            'search' => $search,
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'found'=> $found
        ]);
    }


    public function faturamento(){

        if(Auth::check()===true){
            if(Auth::user()->admin==1){

                $maisVendidos = Produto::all();
        
                if($maisVendidos){
                    return view('admin.fatProdutos')->with([
                        'maisVendidos'=> $maisVendidos
                    ]);
                }

                // return $maisVendidos[0]->cat;
                // die;

            }
        }
        return redirect()->route('admin.login');
    }



}
