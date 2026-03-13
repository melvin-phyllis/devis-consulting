@extends('layouts.sidebar')

@section('title', 'Nouveau Produit - YA Consulting')

@section('content')
    <div class="page-header">
        <h1>Ajouter un Produit ou Service</h1>
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">← Retour au catalogue</a>
    </div>

    <div class="content-card">
        <h3 style="color: #1e1b4b; margin-top: 0; margin-bottom: 24px; font-size: 1.1em;">📝 Nouveau Produit / Service</h3>
        <form action="{{ route('produits.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Désignation *</label>
                <input type="text" name="designation" required placeholder="Ex: Ordinateur portable, Installation réseau">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prix Unitaire HT (FCFA) *</label>
                    <input type="number" step="0.01" name="prix_unitaire_ht" required placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Type *</label>
                    <select name="type" required>
                        <option value="">-- Sélectionner un type --</option>
                        <option value="produit">📦 Produit</option>
                        <option value="service">⚙️ Service</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Description (Optionnelle)</label>
                <textarea name="description" rows="3" placeholder="Détails supplémentaires..."></textarea>
            </div>

            <div class="btn-group" style="margin-top: 28px;">
                <button type="submit" class="btn btn-success btn-lg">✓ Enregistrer</button>
                <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Liste des produits existants -->
    <div class="content-card">
        <h3 style="color: #1e1b4b; margin-top: 0; font-size: 1.1em;">📋 Catalogue Existant</h3>
        @if(isset($produits) && $produits->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Désignation</th>
                        <th>Type</th>
                        <th>Prix HT (FCFA)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                        <tr>
                            <td>{{ $produit->id }}</td>
                            <td><strong>{{ $produit->designation }}</strong></td>
                            <td>
                                @if($produit->type === 'produit')
                                    <span class="badge badge-info">📦 Produit</span>
                                @else
                                    <span class="badge badge-success">⚙️ Service</span>
                                @endif
                            </td>
                            <td>{{ number_format($produit->prix_unitaire_ht, 2, ',', ' ') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-warning btn-sm">✏️ Éditer</a>
                                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this.closest('form'), 'Supprimer ce produit du catalogue ?')">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>Aucun produit/service pour le moment.</p>
            </div>
        @endif
    </div>
@endsection