<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $objProduct;

    public function __construct()
    {
        $this->objProduct = new Product();
    }

    public function index()
    {
        $produtos = \App\Models\Product::with('category')->get();

        return view('produtos', ['produtos' => $produtos]);
    }

    public function listar()
    {
        $produtos = \App\Models\Product::all();
        return view('produtos', ['produtos' => $produtos]);
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('produtos.create', ['categories' => $categories]);
    }
    public function store(ProductRequest $request)
    {
        $product = $this->objProduct->create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);
        if (!$product) {
            return redirect('produtos/listar')->with('error', 'Erro ao cadastrar o produto.');
        }
        if ($product) {
            return redirect('produtos/listar')->with('success', 'Produto adicionado com sucesso.');;
        }
    }

    public function edit($id)
    {
        $categories = \App\Models\Category::all();
        $product = $this->objProduct->find($id);
        return view('produtos.edit', ['categories' => $categories, 'produto' => $product]);
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->objProduct->where(['id' => $id])->update([
                'name' => $request->name,
                'slug' => str_slug($request->name),
                'price' => $request->price,
                'category_id' => $request->category_id,
                'description' => $request->description
            ]);

            if ($product) {
                // Atualização bem-sucedida
                $request->session()->flash('success', 'Produto atualizado com sucesso.');
            } else {
                // Atualização falhou
                $request->session()->flash('error', 'Falha ao atualizar o produto.');
            }
        } catch (\Exception $e) {
            // Tratamento de erro específico, se necessário
            $request->session()->flash('error', 'Falha ao atualizar o produto: ' . $e->getMessage());
        }

        return redirect('produtos/listar');
    }


    public function destroy($id)
    {
        $product = $this->objProduct->find($id);
        if (!$product) {
            return redirect('produtos/listar')->with('error', 'Produto não encontrado.');
        }
        $product->delete();
        return redirect('produtos/listar')->with('success', 'Produto excluído com sucesso.');
    }
}
