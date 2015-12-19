<?php namespace Keios\Support\Models;

use Illuminate\Support\Facades\Cache;
use October\Rain\Database\Model;


/**
 * Class Settings
 *
 * @package Keios\Support\Models
 */
class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    protected $guarded = ['*'];

    protected $fillable = ['address'];

    public $settingsCode = 'keios::support.settings';

    public $settingsFields = 'fields.yaml';

}