<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload un fichier et retourne le chemin
     */
    public function uploadFile(UploadedFile $file, string $directory = 'tutorials'): array
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                    . '.' . $file->getClientOriginalExtension();
        
        $path = $file->storeAs($directory, $filename, 'public');
        
        return [
            'path' => $path,
            'size' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Upload une image/miniature
     */
    public function uploadThumbnail(UploadedFile $file): string
    {
        $filename = time() . '_thumb_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                    . '.' . $file->getClientOriginalExtension();
        
        return $file->storeAs('thumbnails', $filename, 'public');
    }

    /**
     * Supprimer un fichier
     */
    public function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Obtenir l'URL publique d'un fichier
     */
    public function getFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Vérifier si un fichier existe
     */
    public function fileExists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }
}