<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = \App\Models\Setting::first();
        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo'   => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp|max:4096',
            'cachet' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp|max:4096',
        ], [
            'logo.mimes'   => 'Le logo doit être une image (JPG, PNG, GIF, SVG, WEBP).',
            'logo.max'     => 'Le logo ne doit pas dépasser 4 Mo.',
            'cachet.mimes' => 'Le cachet doit être une image (JPG, PNG, GIF, SVG, WEBP).',
            'cachet.max'   => 'Le cachet ne doit pas dépasser 4 Mo.',
        ]);

        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting(['user_id' => auth()->id()]);

        $data = $request->only(['nom_entreprise', 'adresse', 'telephone', 'telephone2', 'email', 'rccm_cc', 'ncc', 'tva_defaut', 'devise', 'site_web', 'prefixe_entreprise', 'code_ville', 'pdf_template']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($settings->logo) Storage::disk('public')->delete($settings->logo);
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $data['logo'] = $settings->logo;
        }

        if ($request->hasFile('cachet') && $request->file('cachet')->isValid()) {
            if ($settings->cachet) Storage::disk('public')->delete($settings->cachet);
            $data['cachet'] = $request->file('cachet')->store('cachets', 'public');
        } else {
            $data['cachet'] = $settings->cachet;
        }

        $settings->fill($data);
        $settings->save();

        return back()->with('success', 'Paramètres mis à jour !');
    }
}
