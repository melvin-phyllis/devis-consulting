<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1.6cm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a2a5a;
            margin: 0;
            padding: 0 0 1.1cm 0;
        }

        /* Entête */
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
        }

        .ref-doc {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            vertical-align: top;
            padding-top: 10px;
            /* Ajuste la hauteur exacte */
        }

        /* Infos Émetteur et Client */
        .section-info {
            width: 100%;
            margin-bottom: 30px;
        }

        .title-box {
            border: 3px solid #1a2a5a;
            text-align: center;
            padding: 8px;
            width: 50%;
            margin: 12px auto;
            font-size: 16px;
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
            background-color: #a9a9a9;
            border: 1.5px solid #000;
            padding: 4px 5px;
            text-transform: uppercase;
            font-size: 10px;
        }

        .items-table td {
            border: 1.5px solid #000;
            padding: 2px 4px;
            color: #000;
        }

        .items-table thead {
            display: table-header-group;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Bloc bas de page : cachet + modes de paiement + totaux — sans cadre noir ni séparation verticale */
        .footer-summary {
            width: 100%;
            margin-top: 18px;
            page-break-inside: avoid;
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
            color: #444;
            line-height: 1.25;
        }

        .total-table {
            width: 100%;
            max-width: 320px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .total-table td {
            border: none;
            padding: 4px 0;
            font-weight: bold;
        }

        .total-table tr.row-highlight td {
            background-color: #f3f4f6;
            padding: 6px 8px;
        }

        .total-table tr:not(.row-highlight) td {
            border-bottom: 1px solid #e5e7eb;
        }

        .total-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Pied de page bleu (légal) — sous le bloc totaux/cachet */
        .footer-blue {
            margin-top: 16px;
            padding-top: 10px;
            text-align: center;
            color: #00acee;
            font-size: 9px;
            line-height: 1.2;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td>
                @if(isset($settings) && $settings->logo)
                    <img src="{{ storage_path('app/public/' . $settings->logo) }}" class="logo">
                @else
                    <img src="{{ public_path('images/logo-ya.png') }}" class="logo">
                @endif
            </td>
            <td class="ref-doc">
                N° {{ $devis->numero }}
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 40%; vertical-align: top;">
                <p><strong>Émetteur :</strong></p>
                <p><strong>{{ $settings->nom_entreprise ?? 'YA CONSULTING' }}</strong><br>
                    {{ $settings->adresse ?? 'Abidjan' }}<br><br>
                    Tél.: {{ $settings->telephone ?? '+225 01 52 22 63 12' }}<br>
                    Email: {{ $settings->email ?? 'courriel@ya-consulting.com' }}<br>
                    @if(isset($settings->site_web) && $settings->site_web)
                        Site web : {{ $settings->site_web }}
                    @else
                        Site web : www.ya-consulting.com
                    @endif
                </p>
            </td>
            <td style="text-align: center; vertical-align: top;">
                <p>{{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</p>
            </td>
            <td style="width: 40%; text-align: right; vertical-align: top;">
                <p><strong>Destinataire</strong></p>
                @if(isset($devis->client->logo) && $devis->client->logo)
                    <img src="{{ storage_path('app/public/' . $devis->client->logo) }}"
                        style="width: 80px; height: auto; margin-bottom: 5px; float: right; clear: both;"><br>
                @endif
                <p style="clear: both;"><strong>{{ $devis->client->raison_sociale }}</strong><br>
                    {{ $devis->client->adresse ?? '' }}</p>
            </td>
        </tr>
    </table>

    <div class="title-box">
        {{ $devis->titre_document ?? (($devis->type ?? 'devis') == 'facture' ? 'FACTURE PROFORMA' : 'DEVIS') }}
    </div>

    <p style="margin-left: 10px;"><strong>Objet :</strong>
        {{ $devis->objet ?? 'Prestations de services / Ventes de matériels' }}</p>
    <p style="margin-left: 10px; font-weight: bold; text-align: right;">Montants exprimés en FCFA BCEAO</p>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 45%;">DESIGNATION</th>
                <th style="width: 20%;">P.U.H.T</th>
                <th style="width: 10%;">Qté</th>
                <th style="width: 25%;">Total HT</th>
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
                                style="max-width: {{ $devis->lignes->count() <= 11 ? 75 : 95 }}px; max-height: {{ $devis->lignes->count() <= 11 ? 60 : 80 }}px; width: auto; height: auto; opacity: 0.95;">
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
                                    <tr style="background: #f3f4f6;">
                                        <th style="border: 1px solid #ccc; padding: 1px 3px; text-align: left;">Date</th>
                                        <th style="border: 1px solid #ccc; padding: 1px 3px; text-align: right;">Montant</th>
                                        <th style="border: 1px solid #ccc; padding: 1px 3px;">Mode</th>
                                        <th style="border: 1px solid #ccc; padding: 1px 3px;">Réf.</th>
                                    </tr>
                                    @foreach($devis->paiements as $p)
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 1px 3px;">{{ $p->date_paiement->format('d/m/Y') }}</td>
                                        <td style="border: 1px solid #ccc; padding: 1px 3px; text-align: right;">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                                        <td style="border: 1px solid #ccc; padding: 1px 3px;">{{ $p->mode_paiement ?? '—' }}</td>
                                        <td style="border: 1px solid #ccc; padding: 1px 3px;">{{ $p->reference ?? '—' }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            @endif
                        @else
                            <p style="margin: 0 0 4px 0; font-size: 7px; color:#555;">Acompte 30% &nbsp;|&nbsp; Validité du devis : 3 mois</p>
                            <p style="font-size: 9px; margin: 0; line-height: 1.2;">
                                <strong>Modes de paiement :</strong><br>
                                Chèque, Virement bancaire<br>
                                Mobile Money (Wave, Orange, Moov, MTN)
                            </p>
                        @endif
                    </div>
                </td>
                <td class="footer-right-col">
                    <table class="total-table">
                        <tr>
                            <td style="width: 45%;">TOTAL HT</td>
                            <td class="text-right">{{ number_format($devis->total_ht, 0, ',', ' ') }}</td>
                        </tr>
                        @php
                            $tvaPctPdf = (float) ($devis->taux_tva ?? 0);
                            $tvaLibellePdf = 'TVA (' . ($tvaPctPdf <= 0 ? '0' : (abs($tvaPctPdf - round($tvaPctPdf)) < 0.001 ? (string) (int) round($tvaPctPdf) : number_format($tvaPctPdf, 2, ',', ' '))) . ' %)';
                        @endphp
                        <tr>
                            <td>{{ $tvaLibellePdf }}</td>
                            <td class="text-right">{{ number_format($devis->total_tva, 0, ',', ' ') }}</td>
                        </tr>
                        <tr class="row-highlight">
                            <td>TOTAL TTC</td>
                            <td class="text-right">{{ number_format($devis->total_ttc, 0, ',', ' ') }}</td>
                        </tr>
                        @if(isset($devis->type) && $devis->type === 'facture')
                        @php
                            $paye = (float) ($devis->montant_paye ?? 0);
                            $reste = max(0, (float) $devis->total_ttc - $paye);
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
                            <td colspan="2" style="font-size: 9px; font-style: italic; padding-top: 10px; border: none !important;">
                                @if(isset($devis->type) && $devis->type === 'facture')
                                    @php $resteLettres = \App\Models\Document::francsEntiersPourLettres($devis->reste_a_payer); @endphp
                                    <strong>Reste dû en lettres :</strong>
                                    @if($resteLettres <= 0)
                                        Zéro franc CFA (facture soldée).
                                    @else
                                        {{ ucfirst(\App\Models\Document::nombreEnLettres($resteLettres)) }} francs CFA
                                    @endif
                                @else
                                    <strong>Montant en lettres :</strong> {{ ucfirst($devis->montant_en_lettres) }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-blue">
        YA CONSULTING-RCCM: N CI-ABJ-2020-B-13747, NCC: 2046187R, Siège social: Riviera Palmeraie, Cocody, Abidjan, Côte
        d'Ivoire.<br>
        Tél: (225) 01 52 22 63 12, (225) 05 65 24 69 74, Email: courriel@ya-consulting.com, www.ya-consulting.com
    </div>

</body>

</html>
