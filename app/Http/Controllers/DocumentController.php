<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chemin_fichier' => 'required|string',
            'categorie' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        // si l'utilisateur fournit un mot de passe, on hash avant sauvegarde
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        Document::create($data);

        return redirect()->back()->with('success', 'Document créé avec succès.');
    }

    /**
     * Verify the given password against the stored hash.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyPassword(Request $request, Document $document)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Si aucun mot de passe n'est défini, on laisse passer
        if (!$document->password) {
            return redirect()->back();
        }

        if (Hash::check($request->input('password'), $document->password)) {
            // mot de passe correct, on peut par exemple afficher le document
            return redirect()->route('documents.show', $document);
        }

        // mot de passe incorrect -> flash d'erreur
        return redirect()->back()->with('error', 'Mot de passe incorrect.');
    }
}
