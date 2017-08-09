<?php

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
