<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord - Gestion de Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- 1. قسم إضافة منتج جديد - متاح فقط للأدمين --}}
                @if(auth()->user()->role == 'admin')
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="text-lg font-bold mb-4 text-blue-700">Ajouter un nouveau produit</h3>
                        <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            @csrf
                            <input type="text" name="designation" placeholder="Nom / Désignation" class="border p-2 rounded" required>
                            
                            <select name="category_id" class="border p-2 rounded" required>
                                <option value="">Catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nom }}</option>
                                @endforeach
                            </select>

                            <input type="number" name="quantite" placeholder="Quantité" class="border p-2 rounded" required>
                            <input type="number" name="prix" placeholder="Prix (DH)" class="border p-2 rounded" required>
                            <input type="number" name="seuil_minimum" placeholder="Seuil Min" class="border p-2 rounded">
                            
                            <button type="submit" class="md:col-span-5 bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700 transition">
                                Enregistrer le produit
                            </button>
                        </form>
                    </div>
                @endif

                {{-- 2. جدول عرض المنتجات --}}
                <div class="overflow-x-auto">
                    <h3 class="text-lg font-bold mb-4">Liste des Articles en Stock</h3>
                    <table class="w-full border-collapse border border-gray-200 shadow-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border p-3 text-left">Désignation</th>
                                <th class="border p-3 text-left">Catégorie</th>
                                <th class="border p-3 text-center">Quantité</th>
                                <th class="border p-3 text-center">Prix Unit.</th>
                                <th class="border p-3 text-center">Statut</th>
                                @if(auth()->user()->role == 'admin')
                                    <th class="border p-3 text-center text-red-600">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border p-3 font-medium">{{ $product->designation }}</td>
                                    <td class="border p-3 text-gray-600">{{ $product->category->nom ?? 'Général' }}</td>
                                    <td class="border p-3 text-center">{{ $product->quantite }}</td>
                                    <td class="border p-3 text-center font-semibold">{{ $product->prix }} DH</td>
                                    
                                    {{-- تنبيه Stock Faible بناء على دفتر التحملات --}}
                                    <td class="border p-3 text-center">
                                        @if($product->quantite <= ($product->seuil_minimum ?? 5))
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold animate-pulse">
                                                Stock Faible
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">
                                                Disponible
                                            </span>
                                        @endif
                                    </td>

                                    {{-- أزرار التحكم للأدمين فقط --}}
                                    @if(auth()->user()->role == 'admin')
                                        <td class="border p-3 text-center">
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold underline">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- في حالة كان الجدول خاوي --}}
                @if($products->isEmpty())
                    <p class="text-center text-gray-500 py-10">Aucun produit trouvé dans le stock.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>