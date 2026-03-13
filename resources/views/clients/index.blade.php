@extends('layouts.sidebar')

@section('title', 'Clients - YA Consulting')

@section('content')
    <div class="page-header">
        <h1>👥 Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-success btn-lg">+ Nouveau Client</a>
    </div>

    <div class="content-card">
        @if($clients->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h2>Aucun client trouvé</h2>
                <p>Commencez par <a href="{{ route('clients.create') }}">ajouter un nouveau client</a></p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Raison sociale</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td><strong>{{ $client->raison_sociale }}</strong></td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm">👁 Voir</a>
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">✏️ Éditer</a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this.closest('form'), 'Supprimer ce client ? Les devis et factures liés restent en base.')">🗑 Suppr.</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
