<?php

/**
 * Run SPAs.
 * 
 * @author pluf<info@pluf.ir>
 *
 */
class Spa_Views_Run
{

    /**
     * Load default spa
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     * @return Pluf_HTTP_Response_File|Pluf_HTTP_Response
     */
    public static function defaultSpa ($request, $match)
    {
        $name = Setting_Service::get('spa.default', 'not-found');
        $spa = Spa_SPA::getSpaByName($name);
        if (! isset($spa)) {
            $spa = Spa_Service::getNotfoundSpa();
        }
        $resPath = $spa->getMainPagePath();
        return new Pluf_HTTP_Response_File($resPath, 
                Pluf_FileUtil::getMimeType($resPath));
    }

    /**
     * Load a resource from SPA
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     * @return Pluf_HTTP_Response_File|Pluf_HTTP_Response
     */
    public static function loadResource ($request, $match)
    {
        // Load data
        if(array_key_exists('resource', $match)){
            $resourcePath = $match['resource'];
        }
        $spaName = $match['spa'];
        $spa = Spa_SPA::getSpaByName($spaName);
        
        // SPA is valid
        if (isset($spa)) {
            if (!isset($resourcePath) || empty($resourcePath)) {
                $resPath = $spa->getMainPagePath();
            } else {
                $resPath = $spa->getResourcePath($resourcePath);
            }
            return new Pluf_HTTP_Response_File($resPath, 
                    Pluf_FileUtil::getMimeType($resPath));
        }
        
        // Looking for file in default spa
        $name = Setting_Service::get('spa.default', 'not-found');
        $spa = Spa_SPA::getSpaByName($name);
        $resPath = $spa->getResourcePath($match[0]);
        if (file_exists($resPath)) {
            return new Pluf_HTTP_Response_File($resPath, 
                    Pluf_FileUtil::getMimeType($resPath));
        }
        
        $spa = Spa_Service::getNotfoundSpa();
        
        // Looking for file in notfound spa
        $w = $match[0];
        do {
            $w = substr($w, strpos($w, '/')+1);
            $resPath = $spa->getResourcePath($w);
            if (file_exists($resPath)) {
                return new Pluf_HTTP_Response_File($resPath, 
                        Pluf_FileUtil::getMimeType($resPath));
            }
        } while (strpos($w, '/'));
        
        // not found spa main page
        $resPath = $spa->getMainPagePath();
        return new Pluf_HTTP_Response_File($resPath, 
                Pluf_FileUtil::getMimeType($resPath));
    }
}