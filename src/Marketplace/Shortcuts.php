<?php
Pluf::loadFunction('Pluf_Form_Field_File_moveToUploadFolder');

/**
 *
 * @param Marketplace_Spa $spa
 * @return Marketplace_Spa_Manager_Simple
 */
function Marketplace_Shortcuts_SpaManager($spa)
{
    // XXX: maso, 2017: read from settings
    $manager = new Marketplace_Spa_Manager_Simple();
    return $manager;
}

/**
 *
 * @param Pluf_HTTP_Request $request
 * @param Marketplace_Spa $spa
 */
function Marketplace_Shortcuts_SpaUpdate($request, $spa)
{
    // Upload file
    $path = Pluf::f('temp_folder', '/tmp') . '/' . $spa->id . '.zip';
    Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'], array(
        'file_name' => $spa->id . '.zip',
        'upload_path' => Pluf::f('temp_folder', '/tmp'),
        'upload_path_create' => true,
        'upload_overwrite' => true
    ));
    
    // Temp folder
    $key = 'spa-' . md5(microtime() . rand(0, 123456789));
    $dir = Pluf_Tenant::storagePath() . '/repository/' . $key;
    if (! mkdir($dir, 0777, true)) {
        throw new Pluf_Exception('Failed to create folder in temp');
    }
    
    // Unzip to temp folder
    $zip = new ZipArchive();
    if ($zip->open($path) === TRUE) {
        $zip->extractTo($dir);
        $zip->close();
    } else {
        throw new Pluf_Exception('Unable to unzip SPA.');
    }
    
    // 2- load infor
    $filename = $dir . '/' . Pluf::f('spa_config', 'spa.json');
    $myfile = fopen($filename, 'r') or die('Unable to open file!');
    $json = fread($myfile, filesize($filename));
    fclose($myfile);
    $package = json_decode($json, true);
    
    // 3- update spa
    $spa->setFromFormData($package);
    $spa->file = Pluf_Tenant::storagePath() . '/repository/' . $spa->id;
    copy($path, $spa->file);
    $spa->update();
    
    unlink($path);
    Pluf_FileUtil::removedir($dir);
    return $spa;
}

/**
 * Get Spa
 *
 * @param String $name
 * @throws Pluf_HTTP_Error404
 * @return Marketplace_Spa
 */
function Marketplace_Shortcuts_GetSpaOr404ByName($name)
{
    $sql = new Pluf_SQL('name=%s', array(
        $name
    ));
    $item = Pluf::factory('Marketplace_Spa')->getOne($sql->gen());
    if (isset($item) && $item->name == $name) {
        return $item;
    }
    throw new Pluf_HTTP_Error404("Object not found (SAP," . $name . ")");
}