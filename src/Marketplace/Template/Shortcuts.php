<?php

/**
 *
 * @param Pluf_HTTP_Request $request
 * @param Marketplace_Template $spa
 */
function Marketplace_Template_Shortcuts_update($request, $template)
{
    // Upload file
    Pluf::loadFunction('Pluf_Form_Field_File_moveToUploadFolder');
    $meta = array(
        'file_name' => $template->id,
        'upload_path' => Pluf_Tenant::storagePath() . '/market/templates/',
        'upload_path_create' => true,
        'upload_overwrite' => true
    );
    Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'], $meta);
    
    // update info
    $template->file = $meta['upload_path'] . $meta['file_name'];
    $template->file_name = Pluf_Utils::cleanFileName($request->FILES['file']['name']);
    $template->file_size = 
    $template->update();
    
    return $template;
}

