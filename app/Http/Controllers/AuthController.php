<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
      /**
     * Muestra la vista de inicio de sesión.
     */
    public function index()
    {
        return view("auth.login");
    }

    /**
     * Maneja el inicio de sesión de usuario y almacena el token.
     */
    public function getLogin(Request $request)
    {
        // Validar entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Enviar solicitud de login a la API
        $response = Http::post(env('API_URL') . '/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // Guardar el token en la sesión
            session(['authToken' => $response->json('token')]);

            return redirect()->route('inicio')->with('success', 'Inicio de sesión exitoso');
        } else {
           
            return back()->with(['message' => 'Credenciales incorrectas']);
        }
    }

    /**
     * Muestra la vista de registro.
     */
    public function create()
    {
        return view("auth.register");
    }

    /**
     * Registra un nuevo usuario a través de la API.
     */
    public function store(Request $request)
    {
        // Validar entrada

        // Enviar solicitud de registro a la API
        $response = Http::post(env('API_URL') . '/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->successful()) {
            return redirect()->route('auth.login')->with('success', 'Registro exitoso. Por favor, inicie sesión.');
        } else {
            return back()->withErrors($response->json());
        }
    }

    /**
     * Genera un nuevo token para el usuario autenticado.
     */
    public function generateToken()
    {
        $token = session('authToken');

        $response = Http::withToken($token)->post(env('API_URL') . '/generateToken');

        if ($response->successful()) {
            // Actualizar el token en la sesión si es necesario
            session(['authToken' => $response->json('token')]);

            return redirect()->route('home')->with('success', 'Nuevo token generado exitosamente');
        } else {
            return redirect()->route('auth.login')->withErrors(['message' => 'Error al generar token.']);
        }
    }

    /**
     * Cierra la sesión del usuario autenticado.
     */
    public function logout()
    {
        $token = session('authToken');

        $response = Http::withToken($token)->post(env('API_URL') . '/logout');

        if ($response->successful()) {
            session()->forget('authToken');
            return redirect()->route('auth.login')->with('success', 'Sesión cerrada exitosamente');
        } else {
            return back()->withErrors(['message' => 'Error al cerrar sesión']);
        }
    }
}
