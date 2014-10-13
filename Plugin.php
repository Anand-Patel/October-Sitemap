<?php namespace AnandPatel\Sitemap;

use App;
use Backend;
use Event;
use Illuminate\Foundation\AliasLoader;
use AnandPatel\Sitemap\Models\Settings;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Cms\Classes\Theme;
use System\Classes\PluginManager;
/**
 * Sitemap Plugin Information File
 */
class Plugin extends PluginBase
{

    public $frequencyTypes;
    public $priorityValues;
    public $frequencyComment;
    public $priorityComment;

    public function __construct()
    {
        $this->frequencyTypes = [
                                    'always' => 'Always',
                                    'hourly' => 'Hourly',
                                    'daily'  => 'Daily',
                                    'weekly' => 'Weekly',
                                    'monthly'=> 'Monthly',
                                    'yearly' => 'Yearly',
                                    'never'  => 'Never'
        ];

        $this->priorityValues = [
                                    '0.0'   => '0.0',
                                    '0.1'   => '0.1',
                                    '0.2'   => '0.2',
                                    '0.3'   => '0.3',
                                    '0.4'   => '0.4',
                                    '0.5'   => '0.5',
                                    '0.6'   => '0.6',
                                    '0.7'   => '0.7',
                                    '0.8'   => '0.8',
                                    '0.9'   => '0.9',
                                    '1.0'   => '1.0',
        ];

        $this->frequencyComment = "Provides a hint about how frequently the page is likely to change.";
        $this->priorityComment = "Describes the priority of a URL relative to all the other URLs on the site. ";

    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Sitemap',
                'description' => 'Sitemap configuration',
                'icon'        => 'icon-sitemap',
                'class'       => 'AnandPatel\Sitemap\Models\Settings',
                'order'       => 100,
                'context'     => 'mysettings',
                'category'    =>  SettingsManager::CATEGORY_MYSETTINGS,
            ]
        ];
    }


    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Sitemap',
            'description' => 'Generate Sitemap for CMS pages, static Pages, blog Posts, blog categories',
            'author'      => 'AnandPatel',
            'icon'        => 'icon-sitemap'
        ];
    }

    public function boot()
    {

        \App::register("Roumen\Sitemap\SitemapServiceProvider");

        Event::listen('backend.form.extendFields', function($form)
        {
            /*
             * Check for the installed plugin if install then extends fields for that
             */
            if ($form->model instanceof \AnandPatel\Sitemap\Models\Settings)
            {
                if (!($theme = Theme::getEditTheme()))
                {
                    throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
                }


                if(PluginManager::instance()->hasPlugin('RainLab.Pages'))
                {

                    $form->addFields([
                        'static_pages' => [
                            'label'     => 'Include RainLab Blog - Categories in Sitemap?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Configuration',
                            'comment'   => 'If checked, RainLab Blog - Categories will be included in sitemap.'
                        ],
                    ],'primary');

                }

                if(PluginManager::instance()->hasPlugin('RainLab.Blog'))
                {
                    $form->addFields([
                        'blog_posts' => [
                            'label'     => 'Include posts in sitemap?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
//                            'comment'   => 'If checked, Posts will be included in sitemap.'
                        ],
                        'blog_categories' => [
                            'label'     => 'Include categories in sitemap?',
                            'type'      => 'switch',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
//                            'comment'   => 'If checked, Categories will be included in sitemap.'
                        ],
                        'blog_posts_lastmod' => [
                            'label'     => 'Include Last modified for posts?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_categories_lastmod' => [
                            'label'     => 'Include Last modified for categories?',
                            'type'      => 'switch',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_posts_change_frequency' => [
                            'label'     => 'Include change frequency for posts?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_categories_change_frequency' => [
                            'label'     => 'Include change frequency for categories?',
                            'type'      => 'switch',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_posts_priority' => [
                            'label'     => 'Include priority for posts?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_categories_priority' => [
                            'label'     => 'Include priority for categories?',
                            'type'      => 'switch',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],
                        'blog_posts_pages' => [
                            'label'     => 'Select Page on which Post going to display',
                            'type'      => 'dropdown',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog'
                        ],

                        'blog_categories_pages' => [
                            'label'     => 'Select Page on which Categories posts going to display',
                            'type'      => 'dropdown',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
                        ],
                        'blog_posts_frequency' => [
                            'label'     => 'Select Frequency type for posts',
                            'type'      => 'dropdown',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
                            'options'   => $this->frequencyTypes,
//                            'comment'   => $this->frequencyComment
                        ],
                        'blog_categories_frequency' => [
                            'label'     => 'Select Frequency type for categories',
                            'type'      => 'dropdown',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
                            'options'   => $this->frequencyTypes,
//                            'comment'   => $this->frequencyComment
                        ],
                        'blog_posts_priority_val' => [
                            'label'     => 'Select Priority value for posts',
                            'type'      => 'dropdown',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
                            'options'   => $this->priorityValues,
//                            'comment'   => $this->priorityComment
                        ],
                        'blog_categories_priority_val' => [
                            'label'     => 'Select Priority value for categories',
                            'type'      => 'dropdown',
                            'span'      => 'right',
                            'default'   => 'false',
                            'tab'       => 'Rainlab Blog',
                            'options'   => $this->priorityValues,
//                            'comment'   => $this->priorityComment
                        ],

                    ],'primary');

                }

                if(PluginManager::instance()->hasPlugin('Autumn.Pages'))
                {
                    $form->addFields([
                        'autumn_pages'  =>  [
                            'label'     => 'Include Autumn Pages in Sitemap?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Configuration',
                            'comment'   => 'If checked, RainLab Blog - Categories will be included in sitemap.'
                        ],
                    ],'primary');
                }
            }

        });
    }

}
