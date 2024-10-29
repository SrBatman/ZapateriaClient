@extends ('layouts.header')

@section('content')

<div class="relative overflow-x-auto">
    <h1 class="text-3xl font-bold text-center my-4">Proovedores</h1>
    <div class="relative overflow-x-auto">
        <a href="/providers/create" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Nuevo proovedor</a>
        @if (!$providers->isEmpty())
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Contacto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estatus
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Editar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Eliminar
                    </th>
                </tr>
            </thead>
            <tbody>
                <div style='display:none;'>
                {{
                    $position=0
                }}
                </div>
                @foreach($providers as $p)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $p->name }}
                    </th>
                    <td class="px-6 py-4">
    
                        {{ $p->contact }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $p->status == 1 ? 'Activo' : 'Inactivo' }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="/providers/edit/{{ $p->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                    </td>
                    <td class="px-6 py-4">
                        <form action="/providers/{{ $p->id }}" method="POST" onsubmit="return confirm('¿Estás seguro que quieres borrar este alumno?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Borrar
                            </button>
                        </form>
                    </td>
                    
                </tr>
                <div style='display:none;'>
                    {{ $position++ }}
                </div>
                
                @endforeach
    
    
            </tbody>
        </table>
        @else
        <h1>No hay registros</h1>
        @endif
    </div>
   
</div>

@endsection