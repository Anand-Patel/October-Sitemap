<?php namespace AnandPatel\Sitemap\Classes;
/**
 * Created by PhpStorm.
 * User: Anand
 * Date: 5/10/14
 * Time: 9:24 PM
 */


use Cms\Classes\Page;
use Cms\Classes\Theme;
use AnandPatel\Sitemap\Models\Settings;
use Cms\Classes\Controller;


class RainLabBlog {


    public function getBlogPostPages()
    {
        $pages = $this->getPagesByComponent('blogPost');
        return $pages;
    }

    public function getBlogCategoryPages()
    {
        $pages = $this->getPagesByComponent("blogPosts");
        return $pages;
    }

    protected function getPagesByComponent($componentName)
    {
        $theme = Theme::getActiveTheme();

        $result = [];
        $pages = Page::sortBy('baseFileName')->all();

        foreach ($pages as $page) {
            if (!$page->hasComponent($componentName))
                continue;

            $result[$page->baseFileName] = $page->title.' ('.$page->baseFileName.')';
        }

        return $result;
    }

    public function getPostsUrls()
    {
        $settings = Settings::instance();

        $posts = \RainLab\Blog\Models\Post::select("slug","updated_at")
                                            ->where("published","=",true)
                                            ->orderBy("updated_at")
                                            ->get();

        $pageName = $settings->blog_posts_pages;
        $controller = new Controller();
        $pageUrl = $controller->pageUrl($pageName);

        $pageUrls = [];




        foreach ($posts as $post)
        {
            $postUrl = [
                            "loc"     => $pageUrl. "/" . $post->slug ,
                            "lastmod" => $post->updated_at ,

            ];

            $pageUrls [] = $postUrl;
        }

        return $pageUrls;
    }


} 