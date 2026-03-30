@extends('layouts.app')
@section('title', 'Produits')
@section('content')

<div class="container mt-5">   
<div class="table-container shadow-sm">
<div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">Liste des Produits</h2>
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Ajouter un Produit
            </a>
        </div>

        <table class="table table-hover border">
            <thead class="table-dark">
<tr>
                    <th>ID</th>
                    <th>Désignation</th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
<tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <th>{{ $product->name }}</th>
                                            <td>
                                                <span class="badge {{ $product->quantity > 10 ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $product->quantity }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($product->price, 2) }} DH</td>
                                            <td class="text-center">
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Modifier</a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Aucun produit</td>
                                        </tr>
                                    @endforelse
                                </tbody>
        </table>
    </div>
</div>

@endsection
