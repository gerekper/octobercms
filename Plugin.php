<?php namespace Devnull\Main;

use App, Backend;
use Illuminate\Foundation\AliasLoader;
use System\Classes\PluginBase;
use Illuminate\Contracts\Http\Kernel;

/**                _                             _
__ _  ___ _ __ ___| | ___ __   ___ _ __ __ _ ___(_) __ _
/ _` |/ _ \ '__/ _ \ |/ / '_ \ / _ \ '__/ _` / __| |/ _` |
| (_| |  __/ | |  __/   <| |_) |  __/ | | (_| \__ \ | (_| |
\__, |\___|_|  \___|_|\_\ .__/ \___|_|(_)__,_|___/_|\__,_|
|___/                   |_|

 * This is a gerekper.main[main] for OctoberCMS
 *
 * @category   Gerekper+ Addons | Main Plugin File
 * @package    Devnull.Main | Octobercms
 * @author     devnull <www.gerekper.asia>
 * @copyright  2012-2016 Gerekper Inc
 * @license    http://www.gerekper.asia/license/modules.txt
 * @version    1.0.0
 * @link       http://www.gerekper.asia/package/helpers
 * @see        http://www.github.com/gerekper
 * @since      File available since Release 1.0.0
 * @deprecated -
 */

class Plugin Extends PluginBase
{
	//----------------------------------------------------------------------//
	//	Construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct()
	{
		$this->code         = 'devnull.main';
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function pluginDetails()
	{
		return [
			'name'          =>  'devnull.main::lang.plugin.name',
			'description'   =>  'devnull.main::lang.plugin.description',
			'author'        =>  'devnull.main::lang.plugin.author',
			'icon'          =>  'icon-bomb',
			'homepage'      =>  'devnull.main::lang.plugin.homepage'
		];
	}

	public function register()
	{
		$alias = AliasLoader::getInstance();
		$alias->alias('Seeding', 'Devnull\Main\Facades\Seeding');
		$alias->alias('InstallMain', 'Devnull\Main\Facades\InstallMain');
		$alias->alias('Robots', 'Devnull\Main\Facades\Robots');
		$alias->alias('Humans', 'Devnull\Main\Facades\Humans');

		App::singleton('main.seeding', function() {
			return \Devnull\Main\Classes\Seeding::instance();
		});

		App::singleton('main.installmain', function() {
			return \Devnull\Main\Classes\InstallMain::instance();
		});

		App::singleton('main.robots', function () {
			return \Devnull\Main\Classes\Robots::instance();
		});

		App::singleton('main.humans', function () {
			return \Devnull\Main\Classes\Humans::instance();
		});
	}

	public function registerNavigation()
	{
		return [
			'menu'  =>  [
				'label'         =>  'devnull.main::lang.components.menu_name',
				'url'           =>  Backend::url('devnull\main\menus'),
				'icon'          =>  'icon-list-alt',
				'permissions'   =>  ['devnull.main.menu*'],
				'order'         =>  500,
				'sideMenu'      =>  [
					'edit'      =>  [
						'label'         =>  'devnull.main::lang.components.menu_editmenu',
						'icon'          =>  'icon-list-alt',
						'url'           =>  Backend::url('devnull/main/menus'),
						'permissions'   =>  ['devnull.main.menu_access'],
					],
					'reorder'   =>  [
						'label' => 'devnull.main::lang.components.menu_reordermenu',
						'icon' => 'icon-exchange',
						'url' => Backend::url('devnull/main/menus/reorder'),
						'permissions' => ['devnull.main.menu_access'],
					]
				]
			]
		];
	}

	public function registerSettings()
	{
		$_value = [
			'settings'  => [
				'label'         =>  'devnull.main::lang.settings.label',
				'description'   =>  'devnull.main::lang.settings.description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-briefcase',
				'url'           =>  Backend::url('devnull/main/settings'),
				'class'         =>  'Devnull\Main\Models\Settings',
				'keywords'      =>  'gerekper main maintenance theme asia umbrella corporation',
				'order'         =>  100,
			],
			'settingsBreadcrumbs' => [
				'label'         =>  'devnull.main::lang.settings.breadcrumbs_label',
				'description'   =>  'devnull.main::lang.settings.breadcrumbs_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-rss-square',
				'url'           =>  Backend::url('devnull/main/settingsBreadcrumbs'),
				'class'         =>  'Devnull\Main\Models\settingsBreadcrumbs',
				'keywords'      =>  'gerekper main breadcrumbs theme asia umbrella corporation',
				'order'         =>  101,
			],
			'settingsDisqus' => [
				'label'         =>  'devnull.main::lang.settings.disqus_label',
				'description'   =>  'devnull.main::lang.settings.disqus_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-comments-o',
				'url'           =>  Backend::url('devnull/main/settingsDisqus'),
				'class'         =>  'Devnull\Main\Models\settingsDisqus',
				'keywords'      =>  'gerekper main theme asia umbrella corporation disqus',
				'order'         =>  102,
			],
			'settingsSeo' => [
				'label'         =>  'devnull.main::lang.settings.seo_label',
				'description'   =>  'devnull.main::lang.settings.seo_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-compass',
				'url'           =>  Backend::url('devnull/main/settingsSeo'),
				'class'         => 'Devnull\Main\Models\SettingsMeta',
				'keywords'      =>  'gerekper main asia umbrellea corporation seo',
				'order'         =>  103
			],
			'settingsCookies' => [
				'label'         =>  'devnull.main::lang.settings.cookies_label',
				'description'   =>  'devnull.main::lang.settings.cookies_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-sellsy',
				'url'           =>  Backend::url('devnull/main/settingsCookies'),
				'class'         =>  'Devnull\Main\Models\settingsCookies',
				'keywords'      =>  'gerekper main asia cookies umbrella corporation',
				'order'         =>   104,
			],
			'settingsTagm' => [
				'label'         =>  'devnull.main::lang.settings.tagm_label',
				'description'   =>  'devnull.main::lang.settings.tagm_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-google',
				'url'           =>  Backend::url('devnull\main\settingsTagm'),
				'class'         =>  'Devnull\Main\Models\settingsTagm',
				'keywords'      =>  'gerekper main asia google tag manager umbrella coorporation',
				'order'         =>  105,
			],
			'settingsRobot' => [
				'label'         =>  'devnull.main::lang.settings.robot_label',
				'description'   =>  'devnull.main::lang.settings.robot_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-rocket',
				'url'           =>  Backend::url('devnull\main\settingsRobot'),
				'class'         =>  'Devnull\Main\Models\settingsRobot',
				'keywords'      =>  'gerekper main asia robots umbrella corporation',
				'order'         =>  106,
			],
			'settingsHuman' =>  [
				'label'         =>  'devnull.main::lang.settings.humans_label',
				'description'   =>  'devnull.main::lang.settings.humans_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-child',
				'url'           =>  Backend::url('devnull\main\settingsHuman'),
				'class'         =>  'Devnull\Main\Models\settingsHuman',
				'keywords'      =>  'gerekper main asia humans umbrella corporation',
				'order'         =>  106
			],
			'settingsCache' =>  [
				'label'         =>  'devnull.main::lang.settings.cache_label',
				'description'   =>  'devnull.main::lang.settings.cache_description',
				'category'      =>  'devnull.main::lang.settings.main_category',
				'icon'          =>  'icon-trash-o',
				'url'           =>  Backend::url('devnull\main\settingsCache'),
				'class'         =>  'Devnull\Main\Models\settingsCache',
				'keywords'      =>  'gerekper main asia cache umbrella corporation',
				'order'         =>  107
			],

		];

		return $_value;
	}

	public function registerComponents()
	{
		return [
			//'Devnull\Main\Components\Disqus'                =>  'disqus',
			//'Devnull\Main\Components\DisqusComments'        =>  'disquscomments',
			'Devnull\Main\Components\Breadcrumbs'           =>  'Breadcrumbs',
			'Devnull\Main\Components\LogoFav'               =>  'Logo',
			'Devnull\Main\Components\MetaCom'               =>  'MetaCom',
			'Devnull\Main\Components\Menu'                  =>  'Menu',
			//'Devnull\Main\Components\CookieNotification'    =>  'cookieNotification',
			//'Devnull\Main\Components\FooterList'            =>  'footerList',
		];
	}

	public function registerPermissions()
	{
		return [
			'devnull.main.access_plugin'                =>  ['label' => 'devnull.main::lang.permissions.access_plugin'],
			'devnull.main.disqus_access_settings'       =>  ['label' => 'devnull.main::lang.permissions.disqus_access_settings'],
			'devnull.main.disqus_access_configurations' =>  ['label' => 'devnull.main::lang.permissions.disqus_access_configurations'],
			'devnull.main.disqus_access_logs'           =>  ['label' => 'devnull.main::lang.permissions.disqus_access_logs'],

			'devnull.main.cookies_access_settings'      =>  ['label' => 'devnull.main::lang.permissions.cookies_access_settings'],
			'devnull.main.cookies_access_components'    =>  ['label' => 'devnull.main::lang.permissions.cookies_access_components'],
			'devnull.main.cookies_access_logs'          =>  ['label' => 'devnull.main::lang.permissions.cookies_access_logs'],

			'devnull.main.seo_access_settings'          =>  ['label' => 'devnull.main::lang.permissions.seo_access_settings'],
			'devnull.main.seo_access_directives'        =>  ['label' => 'devnull.main::lang.permissions.seo_access_directives'],
			'devnull.main.seo_access_ldirectives'       =>  ['label' => 'devnull.main::lang.permissions.seo_access_ldirectives'],
			'devnull.main.seo_access_system'            =>  ['label' => 'devnull.main::lang.permissions.seo_access_system'],

			'devnull.main.breadcrumbs_access_plugin'    =>  ['label' => 'devnull.main::lang.permissions.breadcrumbs_access_plugin'],
			'devnull.main.menu_access'                  =>  ['label' => 'devnull.main::lang.permissions.menu_access'],

			];
	}

	public function registerSchedule($schedule)
	{
		$schedule->command('cache:clear')->everyFiveMinutes();
	}

	public function registerFormWidgets()
	{
		return [
			'Owl\FormWidgets\HasMany\Widget' => [
				'label' =>  'HasMany',
				'code'  =>  'owl-hasmany',
			]
		];
	}

	public function registerReportWidgets()
	{
		/*
		 * return [
		 *  'Devnull\Main\ReportWidgets\SeoViewAll'     => [
		 *      'label'     =>  'devnull.main::lang.plugin.SeoViewAll',
		 *      'context'   =>  'Dashboard'
				]
			];
		*/
		return [
			'Devnull\Main\ReportWidgets\ClearCache' => ['label' => 'devnull.main::lang.reportWidgets.cache_widget_label', 'context' => 'dashboard'],
		];
	}

	public function registerMarkupTags()
	{
		return [
			'functions' =>  [
				'form_select_type'      =>  ['Devnull\Main\Models\Meta', 'formSelect'],
				'form_select_property'  =>  ['Devnull\Main\Models\MetaDirective', 'formSelect']
			]
		];
	}

	public function boot()
	{
		set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/vendor/google/apiclient/src');
	}

	public function registerListColumnTypes(){}
	public function registerMailTemplates(){}

	//----------------------------------------------------------------------//
	//	Plugin Functions - end
	//----------------------------------------------------------------------//
}