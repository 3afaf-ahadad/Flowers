<?php

namespace App\Http\Controllers;

 Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Affiche tous les documents (pour le Dashboard de Sou)
    public function index() 
    {
        // On récupère uniquement les docs de l'utilisateur connecté (Lien avec Saa)
        $documents = Document::where('user_id', session('user_id'))->get();
        return view('dashboard', compact('documents'));
    }

    // Enregistre le document (L'action principale de Ghita)
    public function store(Request $request)
    {
        // 1. La Validation (Le Bouclier)
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|mimes:pdf,docx,png,jpg|max:2048', // Max 2Mo
        ]);

        if ($request->hasFile('fichier')) {
            // 2. L'Upload physique dans storage/app/public/documents
            $path = $request->file('fichier')->store('documents', 'public');

            // 3. Sauvegarde en base de données
            $doc = new Document();
            $doc->titre = $request->titre;
            $doc->chemin_fichier = $path;
            $doc->user_id = session('user_id'); // On lie à l'utilisateur actuel
            $doc->save();

            // 4. Message Flash pour Salah et Nouhaila
            return redirect()->back()->with('success', 'Document ajouté avec succès !');
        }
    }

    // Suppression (La propreté du serveur)
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Supprime le fichier physique du disque dur
        if (Storage::disk('public')->exists($document->chemin_fichier)) {
            Storage::disk('public')->delete($document->chemin_fichier);
        }

        // Supprime la ligne dans la base de données
        $document->delete();

        return redirect()->back()->with('error', 'Document supprimé.');
    }
};