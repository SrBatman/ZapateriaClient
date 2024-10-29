<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return view("providers.index");
        $authToken = session('authToken');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->get(env('API_URL') . '/providers');

            if ($response->successful()) {
                $data = $response->json();

                $providers = collect($data['data'])->map(function ($encryptedProvider) {
                    return json_decode(Crypt::decryptString($encryptedProvider));
                });

                $message = Crypt::decryptString($data['message']);
                
                return view("providers.index", compact('providers', 'message'));
            }

            return back()->with('error', 'No se pudo obtener la lista de proveedores.');
        } catch (\Exception $e) {
            dd($e);
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("providers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authToken = session('authToken');
        
        try {
 
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->post(env('API_URL') . '/providers', [
                'name' => $request->name,
                'contact' => $request->contact,
            ]);
        
           
            if ($response->successful()) {
                $data = $response->json();
                
                // Desencriptar mensaje y proveedor
                $message = Crypt::decryptString($data['message']);
               
                return redirect()->route('providers.index')->with('success', $message);
            }
        
            return back()->with('error', 'No se pudo agregar el proveedor.');
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error al agregar el proveedor.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $authToken = session('authToken');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->get(env('API_URL') . "/providers/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                $provider = json_decode(Crypt::decryptString($data['provider']));
                $message = Crypt::decryptString($data['message']);

                return view("providers.show", compact('provider', 'message'));
            }

            return back()->with('error', 'Proveedor no encontrado.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener el proveedor.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authToken = session('authToken');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->get(env('API_URL') . "/providers/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                $provider = json_decode(Crypt::decryptString($data['provider']));
                return view("providers.edit", compact('provider', 'id'));
            }

            return back()->with('error', 'Proveedor no encontrado.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error al cargar el formulario de edición.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $authToken = session('authToken');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->put(env('API_URL') . "/providers/{$id}", [
                'name' => $request->name,
                'contact' => $request->contact,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $message = Crypt::decryptString($data['message']);
                return redirect()->route('providers.index')->with('success', $message);
            }

            return back()->with('error', 'No se pudo actualizar el proveedor.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error al actualizar el proveedor.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $authToken = session('authToken');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
            ])->delete(env('API_URL') . "/providers/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                $message = Crypt::decryptString($data['message']);
                return redirect()->route('providers.index')->with('success', $message);
            }

            return back()->with('error', 'No se pudo eliminar el proveedor.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar el proveedor.');
        }
    }
}