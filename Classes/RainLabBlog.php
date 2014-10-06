<?php
/**
 * Created by PhpStorm.
 * User: Anand
 * Date: 5/10/14
 * Time: 9:24 PM
 */

namespace AnandPatel\Sitemap\Classes;


use Cms\Classes\Page;
use Cms\Classes\Theme;

class RainLabBlog {


    public function getRainLabBlogPostPages()
    {
        $theme = Theme::getActiveTheme();

        $pages = Page::listInTheme($theme, true);
        $cmsPages = [];
        foreach ($pages as $page)
        {
            if (!$page->hasComponent('blogPosts'))
            continue;

//            $properties = $page->getComponentProperties('blogPosts');
//            if (!isset($properties['categoryFilter']) || substr($properties['categoryFilter'], 0, 1) !== ':')
//            continue;

            $cmsPages[] = $page;
        }

        $result = $cmsPages;
        return $result;
    }

} 