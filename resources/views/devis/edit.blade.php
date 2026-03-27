@extends('layouts.sidebar')

@section('title', 'Éditer le Devis - YA Consulting')

@section('styles')
<style>
    .totals { margin-top: 30px; background: linear-gradient(135deg, #f9fafb, #f3f4f6); padding: 20px; border-radius: 14px; text-align: right; border: 2px solid #e5e7eb; }
    .totals p { margin: 5px 0; font-size: 1em; color: #374151; }
    .total-ttc { color: #4f46e5 !important; font-size: 1.3em !important; font-weight: 700; }
    #btn-tva-0.active, #btn-tva-18.active { background: #4f46e5; color: #fff; border-color: #4f46e5; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>✏️ Éditer le Devis #{{ $devis->numero }}</h1>
        <a href="{{ route('devis.index') }}" class="btn btn-secondary">← Retour à la liste</a>
    </div>

    <div class="content-card">
        <form action="{{ route('devis.update', $devis->id) }}" method="POST" id="devisForm">
        @csrf
        @method('PUT')

        <div class="form-row" style="margin-bottom: 24px;">
            <div class="form-group" style="flex: 2;">
                <label>Sélectionner le Client</label>
                <select name="client_id" required>
                    <option value="">-- Choisir un client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $devis->client_id == $client->id ? 'selected' : '' }}>{{ $client->raison_sociale }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Date d'émission</label>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <input type="date" name="date_emission" id="date_emission" value="{{ old('date_emission', \Carbon\Carbon::parse($devis->date_emission)->format('Y-m-d')) }}" required style="flex: 1; min-width: 160px;">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('date_emission').value = new Date().toISOString().slice(0,10)">Aujourd'hui</button>
                </div>
                <small style="color: #6b7280; display: block; margin-top: 4px;">Cette date figure sur le PDF. « Créé le » reste la date d’enregistrement initial.</small>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label>Objet de la facture</label>
            <input type="text" name="objet" value="{{ $devis->objet ?? '' }}" placeholder="Ex: Fourniture de matériel informatique">
        </div>


        <div class="form-group" style="margin-bottom: 24px;">
            <label>Titre à afficher sur le document</label>
            <select name="titre_document">
                <option value="DEVIS" {{ ($devis->titre_document ?? '') == 'DEVIS' ? 'selected' : '' }}>DEVIS</option>
                <option value="FACTURE PROFORMA" {{ ($devis->titre_document ?? '') == 'FACTURE PROFORMA' ? 'selected' : '' }}>FACTURE PROFORMA</option>
                <option value="FACTURE" {{ ($devis->titre_document ?? '') == 'FACTURE' ? 'selected' : '' }}>FACTURE</option>
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label>Taux de TVA</label>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                <input type="number" name="taux_tva_percent" id="taux_tva_percent" value="{{ old('taux_tva_percent', number_format((float) $devis->taux_tva, 2, '.', '')) }}" min="0" max="100" step="0.01"
                       style="width: 120px; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 10px;" oninput="calculateTotals()">
                <span style="font-weight: 600;">%</span>
                <button type="button" class="btn btn-secondary btn-sm" id="btn-tva-0" onclick="setTva(0)">Sans TVA (0 %)</button>
                <button type="button" class="btn btn-secondary btn-sm" id="btn-tva-18" onclick="setTva(18)">18 %</button>
            </div>
            <small style="color: #6b7280;">0 % = pas de TVA. Ajustez le pourcentage si besoin.</small>
        </div>

        <h3 style="color: #1e1b4b; margin-bottom: 12px;">🛒 Articles / Services</h3>
        <button type="button" class="btn btn-success" onclick="addLine()" style="margin-bottom: 12px;">+ Ajouter un produit</button>

        <table id="lignes-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Désignation</th>
                    <th style="width: 15%;">Quantité</th>
                    <th style="width: 25%;">Prix Unitaire (HT)</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody id="lignes-body">
                @foreach($devis->lignes as $index => $ligne)
                <tr>
                    <td>
                        <select name="lignes[{{ $index }}][produit_id]" class="product-select" required onchange="updatePrice(this)">
                            <option value="">-- Choisir --</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" data-price="{{ $produit->prix_unitaire_ht }}"
                                    {{ $produit->designation == $ligne->designation ? 'selected' : '' }}>
                                    {{ $produit->designation }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="lignes[{{ $index }}][quantite]" class="qty-input" value="{{ $ligne->quantite }}" min="1" required></td>
                    <td><input type="number" name="lignes[{{ $index }}][prix_unitaire]" class="price-input" step="0.01" value="{{ $ligne->prix_unitaire }}" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeLine(this)">✕</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p>Total HT : <strong><span id="display-ht">{{ number_format($devis->total_ht, 0, ',', ' ') }}</span> FCFA</strong></p>
            <p><span id="tva-label">TVA</span> : <strong><span id="display-tva">{{ number_format($devis->total_tva, 0, ',', ' ') }}</span> FCFA</strong></p>
            <p class="total-ttc">Total TTC : <span id="display-ttc">{{ number_format($devis->total_ttc, 0, ',', ' ') }}</span> FCFA</p>
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 24px; padding: 14px;">💾 Mettre à jour le Devis</button>
    </form>
    </div>
@endsection

@section('scripts')
<script>
    let lineCount = {{ count($devis->lignes) }};

    function addLine() {
        const tbody = document.getElementById('lignes-body');
        const firstRow = tbody.rows[0];
        const newRow = firstRow.cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, '[' + lineCount + ']');
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
            else el.value = (el.className === 'qty-input') ? 1 : '';
        });
        tbody.appendChild(newRow);
        lineCount++;
        attachListeners();
    }

    function removeLine(btn) {
        const tbody = document.getElementById('lignes-body');
        if (tbody.rows.length > 1) { btn.closest('tr').remove(); calculateTotals(); }
    }

    function updatePrice(selectEl) {
        const price = selectEl.options[selectEl.selectedIndex].getAttribute('data-price');
        selectEl.closest('tr').querySelector('.price-input').value = price;
        calculateTotals();
    }

    function getTvaRate() {
        const el = document.getElementById('taux_tva_percent');
        let p = parseFloat(el?.value);
        if (isNaN(p) || p < 0) p = 0;
        if (p > 100) p = 100;
        return p / 100;
    }

    function setTva(percent) {
        document.getElementById('taux_tva_percent').value = percent;
        document.getElementById('btn-tva-0')?.classList.toggle('active', percent === 0);
        document.getElementById('btn-tva-18')?.classList.toggle('active', percent === 18);
        calculateTotals();
    }

    function calculateTotals() {
        let totalHT = 0;
        document.querySelectorAll('#lignes-body tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            totalHT += qty * price;
        });
        const rate = getTvaRate();
        const pNum = Math.round(rate * 10000) / 100;
        const pct = pNum <= 0 ? '0' : new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(pNum);
        const tva = totalHT * rate;
        const ttc = totalHT + tva;
        document.getElementById('tva-label').innerText = 'TVA (' + pct + ' %)';
        document.getElementById('display-ht').innerText = new Intl.NumberFormat('fr-FR').format(totalHT);
        document.getElementById('display-tva').innerText = new Intl.NumberFormat('fr-FR').format(tva);
        document.getElementById('display-ttc').innerText = new Intl.NumberFormat('fr-FR').format(ttc);
    }

    function attachListeners() {
        document.querySelectorAll('.qty-input, .price-input').forEach(input => input.addEventListener('input', calculateTotals));
    }
    attachListeners();

    (function initTvaUi() {
        const raw = parseFloat(document.getElementById('taux_tva_percent').value);
        const p = isNaN(raw) ? 0 : raw;
        document.getElementById('btn-tva-0')?.classList.toggle('active', p === 0);
        document.getElementById('btn-tva-18')?.classList.toggle('active', Math.abs(p - 18) < 0.001);
        calculateTotals();
    })();
</script>
@endsection
