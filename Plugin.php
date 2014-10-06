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
                            'label'     => 'Include RainLab Blog - Posts in Sitemap?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Configuration',
                            'comment'   => 'If checked, RainLab Blog - Posts will be included in sitemap.'
                        ],
                        'blog_categories' => [
                            'label'     => 'Include RainLab Blog - Categories in Sitemap?',
                            'type'      => 'switch',
                            'span'      => 'left',
                            'default'   => 'false',
                            'tab'       => 'Configuration',
                            'comment'   => 'If checked, RainLab Blog - Categories will be included in sitemap.'
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
