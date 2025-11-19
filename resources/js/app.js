import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser CKEditor sur tous les textareas avec la classe 'ckeditor'
    const textareas = document.querySelectorAll('textarea.ckeditor');
    
    textareas.forEach(textarea => {
        ClassicEditor
            .create(textarea, {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', '|',
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
                console.log('CKEditor initialisé', editor);
            })
            .catch(error => {
                console.error('Erreur CKEditor:', error);
            });
    });
});