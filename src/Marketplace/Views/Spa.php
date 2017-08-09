<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('Marketplace_Shortcuts_SpaManager');
Pluf::loadFunction('Pluf_Form_Field_File_moveToUploadFolder');

/**
 * Manages spas
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Marketplace_Views_Spa extends Pluf_Views
{

    /**
     * Creates new instance of spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function get ($request, $match)
    {
        // 1- upload & extract
        $key = 'spa-' . md5(microtime() . rand(0, 123456789));
        Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'],
                array(
                        'file_name' => $key . '.zip',
                        'upload_path' => Pluf::f('temp_folder', '/tmp'),
                        'upload_path_create' => true,
                        'upload_overwrite' => true
                ));
        return new Pluf_HTTP_Response_Json($spa);
    }
    
    /**
     * Creates new instance of spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function create ($request, $match)
    {
        // 1- upload & extract
        $key = 'spa-' . md5(microtime() . rand(0, 123456789));
        Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'],
                array(
                        'file_name' => $key . '.zip',
                        'upload_path' => Pluf::f('temp_folder', '/tmp'),
                        'upload_path_create' => true,
                        'upload_overwrite' => true
                ));
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     * Update an spa
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function update ($request, $match)
    {
        $spa = Pluf_Shortcuts_GetObjectOr404('Spa_SPA', $match['spaId']);
        self::remdir($spa->path);
        // 1- upload & extract
        Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'],
                array(
                        'file_name' => 'spa.zip',
                        'upload_path' => $spa->path,
                        'upload_path_create' => true,
                        'upload_overwrite' => true
                ));
        $zip = new ZipArchive();
        if ($zip->open($spa->path . '/spa.zip') === TRUE) {
            $zip->extractTo($spa->path);
            $zip->close();
        } else {
            throw new Pluf_Exception('fail to extract zip package');
        }
        unlink($spa->path . '/spa.zip');
        
        // 2- load infor
        $filename = $spa->path . '/' . Pluf::f('spa_config', "spa.json");
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $json = fread($myfile, filesize($filename));
        fclose($myfile);
        $package = json_decode($json, true);
        
        // 3- update spa
        $spa->setFromFormData($package);
        $spa->update();
        
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public function delete ($request, $match)
    {
        $spa = Pluf_Shortcuts_GetObjectOr404('Spa_SPA', $match['spaId']);
        Pluf_FileUtil::removedir($spa->path);
        $spa->delete();
        return new Pluf_HTTP_Response_Json($spa);
    }
}
