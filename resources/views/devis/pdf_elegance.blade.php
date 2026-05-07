<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0 1.6cm 2cm 1.6cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #222;
            margin: 0;
            padding: 0 0 2cm 0;
        }

        /* Bandeau supérieur sombre */
        .header-band {
            background: #061b31;
            margin: 0 -1.6cm 0 -1.6cm;
            padding: 18px 1.6cm 16px 1.6cm;
            margin-bottom: 24px;
        }

        .header-band-inner {
            width: 100%;
            border-collapse: collapse;
        }

        .header-band-inner td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }

        .logo-cell {
            width: 130px;
        }

        .logo-white-bg {
            background: #fff;
            border-radius: 4px;
            padding: 5px 8px;
            display: inline-block;
        }

        .logo {
            width: 110px;
            display: block;
        }

        .company-cell {
            padding-left: 20px;
        }

        .company-name {
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-info {
            color: rgba(255,255,255,0.65);
            font-size: 9px;
            line-height: 1.5;
        }

        .ref-cell {
            text-align: right;
        }

        .ref-badge {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 4px;
            padding: 8px 14px;
            display: inline-block;
        }

        .ref-label {
            color: rgba(255,255,255,0.55);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 2px;
        }

        .ref-number {
            color: #fff;
            font-size: 15px;
            font-weight: bold;
        }

        /* Infos client / date */
        .info-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .client-box {
            border: 1px solid #e5e7eb;
            border-top: 3px solid #061b31;
            padding: 10px 14px;
            background: #fafafa;
        }

        .client-box-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .date-box {
            text-align: center;
            color: #555;
        }

        .title-box {
            background: #061b31;
            color: #fff;
            text-align: center;
            padding: 9px;
            width: 50%;
            margin: 14px auto;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Tableau des articles */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .items-table th {
            background-color: #061b31;
            color: #fff;
            border: none;
            padding: 6px 6px;
            text-transform: uppercase;
            font-size: 10px;
        }

        .items-table td {
            border: none;
            border-bottom: 1px solid #e5e7eb;
            padding: 4px 6px;
            color: #222;
        }

        .items-table tbody tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .items-table thead {
            display: table-header-group;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Bloc bas de page */
        .footer-summary {
            width: 100%;
            margin-top: 20px;
        }

        .footer-after-items {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
        }

        .footer-after-items td {
            vertical-align: top;
            border: none !important;
            padding: 0;
        }

        .footer-left-col {
            width: 42%;
            padding-right: 16px;
        }

        .footer-right-col {
            width: 58%;
        }

        .cachet-wrap {
            text-align: center;
            margin-bottom: 6px;
        }

        .conditions-devis {
            font-size: 8px;
            color: #555;
            line-height: 1.3;
        }

        /* Tableau des totaux */
        .total-table {
            width: 100%;
            max-width: 320px;
            margin-left: auto;
            border-collapse: collapse;
            border: 1.5px solid #061b31;
        }

        .total-table td {
            border: none;
            padding: 5px 10px;
            font-weight: bold;
        }

        .total-table tr.row-highlight td {
            background-color: #061b31;
            color: #fff;
            padding: 7px 10px;
        }

        .total-table tr:not(.row-highlight):not(:last-child) td {
            border-bottom: 1px solid #e5e7eb;
        }

        .total-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Pied de page sombre */
        .footer-blue {
            position: fixed;
            bottom: -1.6cm;
            left: -1.6cm;
            right: -1.6cm;
            padding: 6px 1.6cm 4px 1.6cm;
            text-align: center;
            color: #555;
            font-size: 9px;
            line-height: 1.2;
            border-top: 2px solid #061b31;
        }
    </style>
</head>

<body>

    {{-- Bandeau supérieur --}}
    <div class="header-band">
        <table class="header-band-inner">
            <tr>
                <td class="logo-cell">
                    @if(isset($settings) && $settings->logo)
                        <div class="logo-white-bg">
                            <img src="{{ storage_path('app/public/' . $settings->logo) }}" class="logo">
                        </div>
                    @endif
                </td>
                <td class="company-cell">
                    @if(isset($settings))
                        <div class="company-name">{{ $settings->nom_entreprise }}</div>
                        <div class="company-info">
                            @if($settings->adresse){{ $settings->adresse }}<br>@endif
                            @if($settings->telephone)Tél: {{ $settings->telephone }}@if($settings->telephone2) / {{ $settings->telephone2 }}@endif<br>@endif
                            @if($settings->email){{ $settings->email }}@endif
                        </div>
                    @endif
                </td>
                <td class="ref-cell">
                    <div class="ref-badge">
                        <span class="ref-label">Référence</span>
                        <span class="ref-number">{{ $devis->numero }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-bottom: 16px;">
        <tr>
            <td style="width: 45%; vertical-align: top;">
                <div class="client-box">
                    <div class="client-box-title">Destinataire</div>
                    @if(isset($devis->client->logo) && $devis->client->logo)
                        <img src="{{ storage_path('app/public/' . $devis->client->logo) }}"
                            style="width: 60px; height: auto; margin-bottom: 4px; display:block;"><br>
                    @endif
                    <strong>{{ $devis->client->raison_sociale }}</strong><br>
                    {{ $devis->client->adresse ?? '' }}
                </div>
            </td>
            <td style="width: 10%; text-align: center; vertical-align: middle; color:#888;">
                <div style="font-size:9px; text-transform:uppercase; letter-spacing:0.5px;">Date</div>
                <div style="font-weight:bold; margin-top:4px;">{{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</div>
            </td>
            <td style="width: 45%;"></td>
        </tr>
    </table>

    <div class="title-box">
        {{ $devis->titre_document ?? (($devis->type ?? 'devis') == 'facture' ? 'FACTURE PROFORMA' : 'DEVIS') }}
    </div>

    <p style="margin-left: 6px;"><strong>Objet :</strong>
        {{ $devis->objet ?? 'Prestations de services / Ventes de matériels' }}</p>
    <p style="margin-left: 6px; font-weight: bold; text-align: right; color:#888; font-size:10px;">Montants exprimés en FCFA BCEAO</p>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 45%; text-align:left;">DESIGNATION</th>
                <th style="width: 20%; text-align:right;">P.U.H.T</th>
                <th style="width: 10%; text-align:center;">Qté</th>
                <th style="width: 25%; text-align:right;">Total HT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devis->lignes as $ligne)
                <tr>
                    <td>{{ $ligne->designation }}</td>
                    <td class="text-right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }}</td>
                    <td class="text-center">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-summary">
        <table class="footer-after-items">
            <tr>
                <td class="footer-left-col">
                    <div class="cachet-wrap">
                        @if(isset($settings) && $settings->cachet)
                            <img src="{{ storage_path('app/public/' . $settings->cachet) }}"
                                alt=""
                                style="max-width: 130px; max-height: 110px; width: auto; height: auto; opacity: 0.95;">
                        @endif
                    </div>
                    <div class="conditions-devis">
                        @if(isset($devis->type) && $devis->type === 'facture')
                            <p style="font-size: 9px; margin: 0 0 6px 0; line-height: 1.2;">
                                <strong>Modes de paiement acceptés :</strong><br>
                                Chèque, Virement bancaire, Mobile Money (Wave, Orange, Moov, MTN)
                            </p>
                            @if(isset($devis->paiements) && $devis->paiements->count() > 0)
                                <p style="font-size: 8px; margin: 0 0 3px 0; color:#555;"><strong>Paiements reçus :</strong></p>
                                <table style="font-size: 7px; width: 100%; border-collapse: collapse;">
                                    <tr style="background: #f8f9fa;">
                                        <th style="border: 1px solid #ddd; padding: 1px 3px; text-align: left;">Date</th>
                                        <th style="border: 1px solid #ddd; padding: 1px 3px; text-align: right;">Montant</th>
                                        <th style="border: 1px solid #ddd; padding: 1px 3px;">Mode</th>
                                        <th style="border: 1px solid #ddd; padding: 1px 3px;">Réf.</th>
                                    </tr>
                                    @foreach($devis->paiements as $p)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 1px 3px;">{{ $p->date_paiement->format('d/m/Y') }}</td>
                                        <td style="border: 1px solid #ddd; padding: 1px 3px; text-align: right;">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                                        <td style="border: 1px solid #ddd; padding: 1px 3px;">{{ $p->mode_paiement ?? '—' }}</td>
                                        <td style="border: 1px solid #ddd; padding: 1px 3px;">{{ $p->reference ?? '—' }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            @endif
                        @else
                            <p style="margin: 0 0 4px 0; font-size: 7px; color:#888;">Acompte 30% &nbsp;|&nbsp; Validité du devis : 3 mois</p>
                            <p style="font-size: 9px; margin: 0; line-height: 1.3;">
                                <strong>Modes de paiement :</strong><br>
                                Chèque, Virement bancaire<br>
                                Mobile Money (Wave, Orange, Moov, MTN)
                            </p>
                        @endif
                    </div>
                </td>
                <td class="footer-right-col">
                    @php
                        $totalHtReel = $devis->lignes->sum(fn($l) => $l->quantite * $l->prix_unitaire);
                        $tvaPctPdf = (float) ($devis->taux_tva ?? 0);
                        $tvaDecimalPdf = $tvaPctPdf / 100;
                        $totalTvaReel = $totalHtReel * $tvaDecimalPdf;
                        $totalTtcReel = $totalHtReel + $totalTvaReel;
                        $tvaLibellePdf = 'TVA (' . ($tvaPctPdf <= 0 ? '0' : (abs($tvaPctPdf - round($tvaPctPdf)) < 0.001 ? (string) (int) round($tvaPctPdf) : number_format($tvaPctPdf, 2, ',', ' '))) . ' %)';
                    @endphp
                    <table class="total-table">
                        <tr>
                            <td style="width: 45%;">TOTAL HT</td>
                            <td class="text-right">{{ number_format($totalHtReel, 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <td>{{ $tvaLibellePdf }}</td>
                            <td class="text-right">{{ number_format($totalTvaReel, 0, ',', ' ') }}</td>
                        </tr>
                        <tr class="row-highlight">
                            <td>TOTAL TTC</td>
                            <td class="text-right">{{ number_format($totalTtcReel, 0, ',', ' ') }}</td>
                        </tr>
                        @if(isset($devis->type) && $devis->type === 'facture')
                        @php
                            $paye = (float) ($devis->montant_paye ?? 0);
                            $reste = max(0, $totalTtcReel - $paye);
                        @endphp
                        <tr>
                            <td>DÉJÀ PAYÉ</td>
                            <td class="text-right">{{ number_format($paye, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr class="row-highlight">
                            <td>RESTE DÛ</td>
                            <td class="text-right">
                                @if($reste <= 0)
                                    0 FCFA (Soldée)
                                @else
                                    {{ number_format($reste, 0, ',', ' ') }} FCFA
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2" style="font-size: 9px; font-style: italic; padding-top: 10px; border: none !important; color:#555;">
                                @if(isset($devis->type) && $devis->type === 'facture')
                                    @php $resteLettresPdf = \App\Models\Document::francsEntiersPourLettres($reste); @endphp
                                    <strong>Reste dû en lettres :</strong>
                                    @if($resteLettresPdf <= 0)
                                        Zéro franc CFA (facture soldée).
                                    @else
                                        {{ ucfirst(\App\Models\Document::nombreEnLettres($resteLettresPdf)) }} francs CFA
                                    @endif
                                @else
                                    @php $ttcEntiersPdf = \App\Models\Document::francsEntiersPourLettres($totalTtcReel); @endphp
                                    <strong>Montant en lettres :</strong> {{ ucfirst(\App\Models\Document::nombreEnLettres($ttcEntiersPdf)) }} francs CFA
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-blue">
        @if(isset($settings))
            @php
                $fl1 = $settings->nom_entreprise ?? '';
                if ($settings->rccm_cc) $fl1 .= '-RCCM: ' . $settings->rccm_cc;
                if ($settings->ncc) $fl1 .= ', NCC: ' . $settings->ncc;
                if ($settings->adresse) $fl1 .= ', Siège social: ' . $settings->adresse;
                $fl2parts = [];
                if ($settings->telephone) $fl2parts[] = 'Tél: ' . $settings->telephone;
                if (!empty($settings->telephone2)) $fl2parts[] = $settings->telephone2;
                if ($settings->email) $fl2parts[] = 'Email: ' . $settings->email;
                if ($settings->site_web) $fl2parts[] = $settings->site_web;
                $fl2 = implode(', ', $fl2parts);
            @endphp
            {{ $fl1 }}<br>{{ $fl2 }}
        @endif
    </div>

</body>

</html>
