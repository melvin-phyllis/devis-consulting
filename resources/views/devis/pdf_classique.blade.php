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
            padding: 0 0 2cm 0;
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
            border: 1.5px solid #000;
        }

        .total-table td {
            border: none;
            padding: 4px 8px;
            font-weight: bold;
        }

        .total-table tr.row-highlight td {
            background-color: #f3f4f6;
            padding: 6px 8px;
        }

        .total-table tr:not(.row-highlight):not(:last-child) td {
            border-bottom: 1px solid #ccc;
        }

        .total-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Pied de page bleu (légal) — fixé tout en bas de la page */
        .footer-blue {
            position: fixed;
            bottom: -1.6cm;
            left: -1.6cm;
            right: -1.6cm;
            padding: 6px 1.6cm 4px 1.6cm;
            text-align: center;
            color: #00acee;
            font-size: 9px;
            line-height: 1.2;
            border-top: 1px solid #00acee;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td>
                @if($logoBase64 ?? null)
                    <img src="{{ $logoBase64 }}" class="logo">
                @endif
            </td>
            <td class="ref-doc">
                N° {{ $devis->numero }}
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 6px;">
        <tr>
            {{-- Émetteur : gauche --}}
            <td style="width: 48%; vertical-align: top; padding-right: 10px;">
                <p style="margin: 0 0 3px 0; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #666; font-weight: bold;">Émetteur</p>
                @if(isset($settings))
                    <strong style="font-size: 12px;">{{ $settings->nom_entreprise }}</strong><br>
                    @if($settings->adresse)<span style="color:#444;">{{ $settings->adresse }}</span><br>@endif
                    @if($settings->telephone)Tél.: {{ $settings->telephone }}<br>@endif
                    @if($settings->email){{ $settings->email }}<br>@endif
                    @if($settings->site_web){{ $settings->site_web }}@endif
                @endif
            </td>
            {{-- Débiteur : droite dans un encadré --}}
            <td style="width: 52%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse; border: 2px solid #1a2a5a; float: right;">
                    <tr>
                        <td style="background: #1a2a5a; color: #fff; font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 8px;">
                            Débiteur / Destinataire
                        </td>
                        <td style="background: #1a2a5a; color: rgba(255,255,255,0.7); font-size: 9px; text-align: right; padding: 4px 8px;">
                            {{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 8px 10px; vertical-align: top;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    @if($clientLogoBase64 ?? null)
                                    <td style="width:110px; vertical-align:middle; padding-right:10px;">
                                        <img src="{{ $clientLogoBase64 }}" style="max-width:100px; max-height:75px; width:auto; height:auto; display:block;">
                                    </td>
                                    @endif
                                    <td style="vertical-align:middle;">
                                        <strong style="font-size:12px;">{{ $devis->client->raison_sociale }}</strong>
                                        @if($devis->client->adresse ?? null)
                                            <br><span style="color:#444; font-size:10px;">{{ $devis->client->adresse }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
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
                        @if($cachetBase64 ?? null)
                            <img src="{{ $cachetBase64 }}"
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
                            <td colspan="2" style="font-size: 9px; font-style: italic; padding-top: 10px; border: none !important;">
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
