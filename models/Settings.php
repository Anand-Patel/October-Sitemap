<?php
/**
 * Created by PhpStorm.
 * User: Anand
 * Date: 5/10/14
 * Time: 7:22 PM
 */

namespace AnandPatel\Sitemap\models;
use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'anandpatel_sitemap_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    protected $cache = [];
} 