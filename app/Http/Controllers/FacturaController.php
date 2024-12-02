<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Para obtener el usuario autenticado
use App\Models\Articulo;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('facturas.index', [
            'facturas' => Factura::where('user_id', Auth::id())->get(), //para que solo salgan las facturas del usuario
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar solo el campo numero
        $validated = $request->validate([
            'numero' => 'required|unique:facturas,numero', // Validación del número de la factura
        ]);

        $validated['user_id'] = Auth::id();
        $factura = Factura::create($validated);
        session()->flash('exito', 'Factura creada correctamente');
        return redirect()->route('facturas.show', $factura);
    }

    /**
     * Display the specified resource.
     */
    public function show(Factura $factura)
    {
        $articulos = Articulo::all();
        return view('facturas.show', [
            'factura'  => $factura,
            'articulos' => $articulos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factura $factura)
    {
        return view('facturas.edit', [
            'factura'  => $factura
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index');
    }

    public function addArticulo(Request $request, Factura $factura)
    {
        $articuloId = $request->input('articulo_id');

        // Asociar el artículo a la factura (muchos a muchos)
        $factura->articulos()->attach($articuloId);

        return redirect()->route('facturas.show', $factura)->with('success', 'Artículo añadido correctamente.');
    }

    public function showArticulos(Factura $factura)
    {
        // Cargar los artículos asociados a la factura
        $factura->load('articulos');

        return view('facturas.show_articulos', [
            'factura' => $factura,
        ]);
    }
}
