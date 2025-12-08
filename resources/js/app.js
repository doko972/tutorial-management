import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Adapter personnalisé pour l'upload
class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(file => {
            return new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);

                fetch('/ckeditor/upload', {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(result => {
                    resolve({ default: result.url });
                })
                .catch(error => {
                    reject(error);
                });
            });
        });
    }

    abort() {
        // Gestion de l'annulation si nécessaire
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea.ckeditor');
    
    textareas.forEach(textarea => {
        ClassicEditor
            .create(textarea, {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'uploadImage', '|',
                        'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraphe', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Titre 3', class: 'ck-heading_heading3' }
                    ]
                },
                language: 'fr'
            })
            .then(editor => {
                // Enregistrer l'adapter personnalisé
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return new MyUploadAdapter(loader);
                };
                console.log('CKEditor initialisé', editor);
            })
            .catch(error => {
                console.error('Erreur CKEditor:', error);
            });
    });
});