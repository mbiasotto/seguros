@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Estabelecimentos</h1>
        <a href="{{ route('admin.establishments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Novo Estabelecimento
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nome</th>
                    <th class="py-3 px-6 text-left">Vendedor</th>
                    <th class="py-3 px-6 text-left">Cidade</th>
                    <th class="py-3 px-6 text-left">Estado</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach($establishments as $establishment)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $establishment->nome }}</td>
                        <td class="py-3 px-6 text-left">{{ $establishment->vendor->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $establishment->cidade }}</td>
                        <td class="py-3 px-6 text-left">{{ $establishment->estado }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="{{ $establishment->ativo ? 'bg-green-200 text-green-600' : 'bg-red-200 text-red-600' }} py-1 px-3 rounded-full text-xs">
                                {{ $establishment->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('admin.establishments.edit', $establishment) }}" class="text-blue-500 hover:text-blue-600 mx-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.establishments.destroy', $establishment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 mx-2" onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $establishments->links() }}
    </div>
</div>
@endsection
