@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Estabelecimentos</h1>
            <p class="text-gray-600">Gerencie todos os estabelecimentos cadastrados</p>
        </div>
        <a href="{{ route('admin.establishments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus-circle"></i>
            <span>Novo Estabelecimento</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r-lg shadow-sm transition duration-500 ease-in-out" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cidade</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($establishments as $establishment)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $establishment->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $establishment->vendor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $establishment->cidade }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $establishment->estado }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="{{ $establishment->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center">
                                    <span class="{{ $establishment->ativo ? 'bg-green-400' : 'bg-red-400' }} rounded-full h-2 w-2 mr-2"></span>
                                    {{ $establishment->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.establishments.edit', $establishment) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out group">
                                        <span class="flex items-center">
                                            <i class="fas fa-edit mr-1.5 group-hover:transform group-hover:scale-110 transition-transform"></i>
                                            <span>Editar</span>
                                        </span>
                                    </a>
                                    <form action="{{ route('admin.establishments.destroy', $establishment) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out group"
                                                onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')">
                                            <span class="flex items-center">
                                                <i class="fas fa-trash mr-1.5 group-hover:transform group-hover:scale-110 transition-transform"></i>
                                                <span>Excluir</span>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $establishments->links() }}
    </div>
</div>
@endsection
