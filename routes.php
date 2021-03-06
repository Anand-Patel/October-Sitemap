<?php
/**
 * Created by PhpStorm.
 * User: Anand
 * Date: 5/10/14
 * Time: 9:57 AM
 */

use AnandPatel\Sitemap\Classes\CmsPages;
use AnandPatel\Sitemap\Classes\RainLabBlog;
Route::get("sitemap",function(){

    $blog = new RainLabBlog();

    $urls = $blog->getPostsUrls();

    return generateSitemap($urls);

    $cmsPages = new CmsPages;
    return $cmsPages->getCMSPages();
});



function generateSitemap($urls)
{
    $output  = '<?xml version="1.0" encoding="UTF-8" ?>';
    $output .= "\n".'<urlset xmlns="http://www.google.com/schemas/sitemap/0.9">'."\n";

    tracelog($urls);

    foreach($urls as $url)
    {
        $output .= "<url>\n";
        $output .= "<loc>"      . $url["loc"] . "</loc>\n";
        $output .= "<lastmod>"  . date('c',strtotime($url["lastmod"])) . "</lastmod>\n";
        $output .= "<changefreq> daily</changefreq>\n";
        $output .= "</url>\n";
    }
    $output .= "</urlset>";
    return Response::make($output, 200)->header('Content-Type', 'application/xml');

}
