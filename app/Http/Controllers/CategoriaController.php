<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $categorias = Categoria::paginate(6);
        return view('categorias', [ 'categorias'=>$categorias ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('categoriaCreate');

    }
    private function validarForm(Request $request)
    {
        $request->validate(

            [
                'catNombre'=>'required|unique:categorias,catNombre|min:2|max:30'
            ],
            [
                'catNombre.required'=>'El campo "Nombre de la categoria" es obligatorio',
                'catNombre.unique'=>'Ya existe una categoria con ese nombre',
                'catNombre.min'=>'El campo "Nombre de la categoria" debe tener al menos 2 caractéres',
                'catNombre.max'=>'El campo "Nombre de la categoria" debe tener 30 caractéres como máximo'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $catNombre = $request->catNombre;
        //validación
        $this->validarForm($request);
        /*almacenar en tabla categorias*/
        try
        {
            //instanciamos
            $categoria = new Categoria;
            //asignamos atributos
            $categoria->catNombre = $catNombre;
            //almacenamos datos en tabla
            $categoria->save();
            return redirect('/categorias')
                    ->with(
                        [
                            'mensaje'=>'Categoria: '.$catNombre.' agregada correctamente',
                            'css'=>'success'
                        ]
                    );

        }catch ( \Throwable $th )
        {
            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'No se pudo agregar la categoria:'.$catNombre,
                        'css'=>'danger'
                    ]
                );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        //
        $categoria = Categoria::find($id);
        return view('categoriaEdit', [ 'categoria'=>$categoria ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) : RedirectResponse
    {
        $catNombre = $request->catNombre;
        //validamos
        $this->validarForm($request);
        //modificamos
        try {
            //obtenemos datos de una categoria por su id
            $categoria = Categoria::find($request->idCategoria);
            //reasigamos atributos
            $categoria->catNombre = $catNombre;
            //almacenamos en tabla categorias
            $categoria->save();

            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'Categoria: '.$catNombre. ' modificada correctamente',
                        'css'=>'success'
                    ]
                );
        }catch ( \Throwable $th )
        {
            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar la categoria: '.$catNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }
    public function delete(string $id) : RedirectResponse | View
    {
        //obtenemosa detos de una marca por su id
        $categoria = Categoria::find($id);
        //si NO hay producto de esa marca
        if( Producto::cantidadProductosPorMarca($id) ){
            //mensaje flashing
            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'No se puede eliminar la categoria: '.$categoria->catNombre.' porque tiene productos relacionados',
                        'css'=>'warning'
                    ]
                );
        }
        //retornar vista de confirmación
        return view('categoriaDelete', [ 'categoria'=>$categoria ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request ) : RedirectResponse
    {
        $catNombre = $request->catNombre;
        try {

            Categoria::destroy($request->idCategoria);
            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'Categoria: '.$catNombre.' eliminada correctamente',
                        'css'=>'success'
                    ]
                );
        }catch ( \Throwable $th )
        {
            return redirect('/categorias')
                ->with(
                    [
                        'mensaje'=>'No se pudo eliminar la categoria: '.$catNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }
}
