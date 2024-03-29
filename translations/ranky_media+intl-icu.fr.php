<?php

declare(strict_types=1);

return [
    'title'                        => 'Image and file management',
    'open_upload_dashboard'        => 'Open the media upload panel',
    'on_remove'                    => 'File deleted successfully',
    'on_update'                    => 'File updated correctly',
    'dropzone'                     => 'Drop files to start the upload process',
    'pagination_info'              => 'Affichage de {courant} sur {total} éléments multimédias',
    'pagination_button_load'       => 'Chargez plus',
    'file'                         => 'Fichier',
    'file_type'                    => 'File Type',
    'type'                         => 'Type',
    'mime'                         => 'MIME',
    'date'                         => 'Date',
    'dimensions'                   => 'Dimensions',
    'size'                         => 'taille',
    'by'                           => 'par',
    'created_at'                   => 'Créé le',
    'updated_at'                   => 'Mis à jour le',
    'breakpoints'                  => 'Versions',
    'filters_user'                 => 'All users',
    'filters_date'                 => 'Tous les dates',
    'filters_mime_type'            => 'Tous les types',
    'filters_search'               => 'Rechercher...',
    'filters_view_list'            => 'List view',
    'filters_view_grid'            => 'Grid view',
    'filters_sort_asc'             => 'Sort ascending',
    'filters_sort_desc'            => 'Sort descending',
    'bulk_actions_title'           => 'Batch actions',
    'bulk_actions_delete'          => 'Delete permanently',
    'bulk_actions_delete_prompt'   => 'Are you sure you want to delete the selected media ({value})?',
    'bulk_actions_error_no_action' => 'No action corresponds to the {value} value',
    'bulk_actions_error_no_select' => 'You must select at least one media to perform a batch action.',
    'form_name'                    => 'Nom',
    'form_alt'                     => 'Texte alternatif',
    'form_title'                   => 'Titre',
    'form_save'                    => 'Sauvegarder',
    'delete'                       => 'Supprimer',
    'modal_title'                  => 'File details {file_name} <small>id: {id}</small>',
    'open_new_window'              => 'Open in a new window',
    'modal_close'                  => 'Close',
    'modal_next'                   => 'Suivant',
    'modal_prev'                   => 'Prévenir',
    'form_type' => [
        'open_selection_button'        => 'Sélectionner un média',
        'clean_selection_button'        => 'Supprimer la sélection',
    ],
    'selection_mode'               => [
        'zero_element'      => 'Aucun élément sélectionné',
        'one_element'       => '1 Aucun élément sélectionné',
        'multiple_elements' => '{length} selected items',
        'clean'             => 'Effacer la sélection',
        'insert'            => 'Insert selection',
    ],
    'swal'                         =>
        [
            'confirm_delete'       => 'Êtes-vous sûr de vouloir supprimer ce média ?',
            'successfully'         => 'Action done correctly',
            'undefined_attributes' => 'The following attributes have not been defined: <b>{attributes}</b>',
            'delete_title'         => 'Êtes-vous sûr de vouloir supprimer ce média ?',
            'delete_text'          => 'Cette action est irréversible',
            'confirm_button'       => 'Accepter',
            'cancel_button'        => 'Annuler',
        ],
    'errors'                       =>
        [
            'not_found'   => 'No media found with ID {id}',
            'bad_request' => 'No value found for the {field} parameter',
            'not_files'   => 'The file could not be uploaded. Not a valid file or the $_FILES variable is empty.',
        ],
];
