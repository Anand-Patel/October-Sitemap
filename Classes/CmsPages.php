<?php
/**
 * Created by PhpStorm.
 * User: Anand
 * Date: 5/10/14
 * Time: 8:54 PM
 */

namespace AnandPatel\Sitemap\Classes;


use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\Controller;
use File;

class CmsPages {


    /**
     * this function returns list of CMS pages
     *
     * @return array
     */
    public function getCMSPages()
    {
        $theme = Theme::getEditTheme();
        $pages = Page::listInTheme($theme, true);

        $pagesAssoc = [];

        foreach($pages as $page)
        {
            if($page['hidden']!=="1")
            {

                $controller = new Controller();
                $url = $controller->pageUrl($page->getFileName());

                $numbersofsec = File::lastModified($page->getFullPath());
                $numbersofsec = date('Y-m-dTH:i:sP', $numbersofsec);

                $pagesAssoc[] = array( $url,$numbersofsec);
            }
        }

        return $pagesAssoc;
    }


} 