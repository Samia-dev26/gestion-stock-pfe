<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord - Gestion de Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Liste des Produits Actuels</h3>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Ajouter Produit
                        </button>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Désignation</th>
                                <th class="px-4 py-2 border">Quantité</th>
                                <th class="px-4 py-2 border">Prix Unit (DH)</th>
                                <th class="px-4 py-2 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $product->id }}</td>
                                    <td class="px-4 py-2 border font-semibold">{{ $product->name }}</td>
                                    <td class="px-4 py-2 border">{{ $product->quantity }}</td>
                                    <td class="px-4 py-2 border">{{ number_format($product->price, 2) }}</td>
                                    <td class="px-4 py-2 border">
                                        @if($product->quantity <= $product->min_stock)
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Stock Faible!</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Disponible</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">
                                        Aucun produit trouvé. Utilisez Tinker pour en ajouter un.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>