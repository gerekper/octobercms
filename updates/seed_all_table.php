<?php namespace Devnull\Main\Updates;

use DB;
use October\Rain\Database\Updates\Seeder;
use Devnull\Main\Classes\InstallMain;
use Devnull\Main\Classes\Seeding;
use Devnull\Main\Classes\SystemSettings;
use Devnull\Main\Models\Settings;
use Devnull\Main\Models\Breadcrumb;
use Devnull\Main\Models\Meta;
use Devnull\Main\Models\MetaDirective;
use Devnull\Main\Models\MetaListDirective;
use Devnull\Main\Models\Robot;
use Devnull\Main\Models\RobotDirective;
use Devnull\Main\Models\RobotAgent;
use Devnull\Main\Models\RobotLog;
use Devnull\Main\Models\Human;
use Devnull\Main\Models\HumanConfig;
use Devnull\Main\Models\HumanInfo;

class SeedAllTable extends Seeder
{
	//----------------------------------------------------------------------//
	//	Construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct()
	{
		$this->_schema                  =   [];
		$this->installations            =   new InstallMain();
		$this->seeding                  =   new Seeding();
		$this->_system_settings         =   'w';
		$this->_main_code               =   'devnull_main_settings';
		$this->time_now                 =   $this->installations->set_date_now();

		$this->_main_breadcrumb         =   Breadcrumb::$_table;
		$this->_main_meta               =   Meta::$_table;
		$this->_main_meta_directive     =   MetaDirective::$_table;
		$this->_main_meta_ldirective    =   MetaListDirective::$_table;
		$this->_main_robot              =   Robot::$_table;
		$this->_main_robot_directive    =   RobotDirective::$_table;
		$this->_main_robot_agent        =   RobotAgent::$_table;
		$this->_main_robot_log          =   RobotLog::$_table;
		$this->_main_human              =   Human::$_table;
		$this->_main_human_config       =   HumanConfig::$_table;
		$this->_main_human_info         =   HumanInfo::$_table;
		//$this->_main_bakery_bakery      =   Bakery::$_table;
		//$this->_main_bakery_category    =   BakeryCategory::$_table;

		$this->_db_variables                =   SystemSettings::get_config_default();
		$this->_db_variables_meta           =   SystemSettings::get_config_meta();
		$this->_db_variables_breadcrumbs    =   SystemSettings::get_config_breadcrumbs();
		$this->_db_variables_robot          =   SystemSettings::get_config_robot();
		$this->_db_variables_robot_log      =   SystemSettings::get_config_robot_log();
		$this->_db_variables_human          =   SystemSettings::get_config_human();
		$this->_db_variables_cache          =   SystemSettings::get_config_clearcache();
		//$this->_db_variables_bakery         =   SystemSettings::get_config_bakery();
		//$this->_db_variables_cookies        =   SystemSettings::get_config_cookies();
		//$this->_db_variables_disqus         =   SystemSettings::get_config_disqus();
		//$this->_db_variables_tagm           =   SystemSettings::get_config_tagm();

		$this->_all_tables  =   [
			$this->_main_breadcrumb, $this->_main_meta, $this->_main_meta_directive, $this->_main_meta_ldirective,
			$this->_main_robot, $this->_main_robot_directive, $this->_main_robot_agent, $this->_main_human_info,
			$this->_main_human_config, $this->_main_human
		];
		$this->_all_config  =   [
			$this->_db_variables, $this->_db_variables_breadcrumbs, $this->_db_variables_meta, $this->_db_variables_robot,
			$this->_db_variables_robot_log, $this->_db_variables_cache,
		];

		$this->_all_codes = [
			SystemSettings::get_main_code()         =>  $this->_db_variables,
			SystemSettings::get_meta_code()         =>  $this->_db_variables_meta,
			SystemSettings::get_breadcrumbs_code()  =>  $this->_db_variables_breadcrumbs,
			SystemSettings::get_robot_code()        =>  $this->_db_variables_robot,
			SystemSettings::get_robot_log_code()    =>  $this->_db_variables_robot_log,
			SystemSettings::get_human_code()        =>  $this->_db_variables_human,
			SystemSettings::get_clearcache_code()   =>  $this->_db_variables_cache,
			//SystemSettings::get_bakery_code()       =>  $this->_db_variables_bakery,
			//SystemSettings::get_cookies_code()      =>  $this->_db_variables_cookies,
			//SystemSettings::get_disqus_code()       =>  $this->_db_variables_disqus,
			//SystemSettings::get_tagm_code()         =>  $this->_db_variables_tagm
		];
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function run() { $this->run_all_seed(); }

	//----------------------------------------------------------------------//
	//	Seed Functions - Start
	//----------------------------------------------------------------------//

	private function run_all_seed()
	{
		foreach($this->_all_tables as $_all_tables)
		{
			$this->installations->check_existing($_all_tables);
			switch($_all_tables)
			{
				case $this->_main_breadcrumb:
					SeedAllTable::init_schema_breadcrumbs();
					break;
				case $this->_main_meta:
					SeedAllTable::init_schema_meta();
					break;
				case $this->_main_meta_directive:
					SeedAllTable::init_schema_meta_directive();
					break;
				case $this->_main_meta_ldirective:
					SeedAllTable::init_schema_meta_ldirective();
					break;
				case $this->_main_robot:
					SeedAlltable::init_schema_robot();
					break;
				case $this->_main_robot_directive:
					SeedAllTable::init_schema_robot_directive();
					break;
				case $this->_main_robot_agent:
					SeedAlltable::init_schema_robot_agent();
					break;
				case $this->_main_human:
					SeedAllTable::init_schema_human();
					break;
				case $this->_main_human_info:
					SeedAllTable::init_schema_human_info();
					break;
				case $this->_main_human_config:
					SeedAllTable::init_schema_human_config();
					break;
				default:
					break;
			}
			$this->installations->optimize_settings();
		}
		SeedAllTable::setSettings($this->_all_codes);
	}

	//----------------------------------------------------------------------//
	//	Init Seed Functions - Start
	//----------------------------------------------------------------------//

	private function init_schema_breadcrumbs()
	{
		foreach($this->seeding->get_schema_breadcrumbs() as $_schema)
		{
			Breadcrumb::updateOrCreate([
				'page_name'         =>  $_schema['page_name'],
				'page_child'        =>  $_schema['page_child'],
				'page_baseFileName' =>  $_schema['page_baseFileName'],
				'hide'              =>  $_schema['hide'],
				'disabled'          =>  $_schema['disabled'],
				'class'             =>  $_schema['class'],
				'type'              =>  $_schema['type'],
				'href'              =>  $_schema['href'],
				'status'            =>  $_schema['status']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(Breadcrumb::$_table);
	}

	//----------------------------------------------------------------------//
	//	SEO Functions - Start
	//----------------------------------------------------------------------//

	private function init_schema_meta()
	{
		foreach ($this->seeding->get_schema_meta() as $_schema)
		{
			Meta::updateOrCreate([
				'page'      =>  $_schema['page'],
				'status'    =>  $_schema['status']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(Meta::$_table);
	}

	private function init_schema_meta_directive()
	{
		foreach ($this->seeding->get_schema_meta_directive() as $_schema)
		{
			MetaDirective::updateOrCreate([
				'meta_id'   =>  $_schema['meta_id'],
				'type'      =>  $_schema['type'],
				'property'  =>  $_schema['property'],
				'content'   =>  $_schema['content'],
				'status'    =>  $_schema['status'],
				'category'  =>  $_schema['category']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(MetaDirective::$_table);
	}

	private function init_schema_meta_ldirective()
	{
		foreach ($this->seeding->get_schema_meta_ldirective() as $_schema)
		{
			MetaListDirective::updateOrCreate([
				'type'      =>  $_schema['type'],
				'property'  =>  $_schema['property'],
				'content'   =>  $_schema['content'],
				'status'    =>  $_schema['status'],
				'category'  =>  $_schema['category']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(MetaListDirective::$_table);
	}

	//----------------------------------------------------------------------//
	//	Robot Functions - Start
	//----------------------------------------------------------------------//

	private function init_schema_robot()
	{
		foreach ($this->seeding->get_schema_robot() as $_schema)
		{
			Robot::updateOrcreate([
				'agent'     =>  $_schema['agent'],
				'status'    =>  $_schema['status'],
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(Robot::$_table);
	}

	private function init_schema_robot_directive()
	{
		foreach ($this->seeding->get_schema_robot_directive() as $_schema)
		{
			RobotDirective::updateOrcreate([
				'robot_id'  =>  $_schema['robot_id'],
				'position'  =>  $_schema['position'],
				'type'      =>  $_schema['type'],
				'data'      =>  $_schema['data']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(RobotDirective::$_table);
	}

	private function init_schema_robot_agent()
	{
		foreach ($this->seeding->get_schema_robot_agent() as $_schema)
		{
			RobotAgent::updateOrCreate([
				'name'          =>  $_schema['name'],
				'desc'          =>  $_schema['desc'],
				'nameId'        =>  $_schema['nameId'],
				'details_url'   =>  $_schema['details_url'],
				'cover_url'     =>  $_schema['cover_url'],
				'owner_name'    =>  $_schema['owner_name'],
				'owner_url'     =>  $_schema['owner_url'],
				'owner_email'   =>  $_schema['owner_email'],
				'ostatus'       =>  $_schema['ostatus'],
				'purpose'       =>  $_schema['purpose'],
				'type'          =>  $_schema['type'],
				'platform'      =>  $_schema['platform'],
				'avail'         =>  $_schema['avail'],
				'excl_agent'    =>  $_schema['excl_agent'],
				'noindex'       =>  $_schema['noindex'],
				'nofollow'      =>  $_schema['nofollow'],
				'host'          =>  $_schema['host'],
				'from'          =>  $_schema['from'],
				'user_agent'    =>  $_schema['user_agent'],
				'lang'          =>  $_schema['lang'],
				'history'       =>  $_schema['history'],
				'env'           =>  $_schema['env'],
				'status'        =>  $_schema['status']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(RobotAgent::$_table);
	}

	//----------------------------------------------------------------------//
	//	Humans.txt Functions - Start
	//----------------------------------------------------------------------//

	private function init_schema_human()
	{
		foreach ($this->seeding->get_schema_human() as $_schema)
		{
			Human::updateOrCreate([
				'attribution'   =>  $_schema['attribution'],
				'status'        =>  $_schema['status']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(Human::$_table);
	}

	private function init_schema_human_config()
	{
		foreach ($this->seeding->get_schema_human_config() as $_schema)
		{
			HumanConfig::updateOrCreate([
				'title' =>  $_schema['title'],
				'desc'  =>  $_schema['desc'],
				'value' =>  $_schema['value'],
				'status'=>  $_schema['status'],
				'url'   =>  $_schema['url']
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(HumanConfig::$_table);
		SeedAllTable::add_human_ascii();
		SeedAllTable::add_human_sig();
	}

	private function init_schema_human_info()
	{
		foreach ($this->seeding->get_schema_human_info() as $_schema)
		{
			HumanInfo::UpdateOrCreate([
				'human_id'  =>  $_schema['human_id'],
				'position'  =>  $_schema['position'],
				'field'     =>  $_schema['field'],
				'value'     =>  $_schema['value'],
			]);
		}
		$this->installations->schema_default();
		$this->installations->optimize_table(HumanInfo::$_table);
	}

	private function add_human_ascii()
	{
		$_add_human_ascii = $this->seeding->get_schema_human_sig();
		DB::table($this->_main_human_config)->insert($_add_human_ascii);
		return true;
	}

	private function add_human_sig()
	{
		$_add_human_sig = $this->seeding->get_schema_human_ascii();
		DB::table($this->_main_human_config)->insert($_add_human_sig);
		return TRUE;
	}

	//----------------------------------------------------------------------//
	//	Shared Functions - Start
	//----------------------------------------------------------------------//

	public function setSettings($_value)
	{
		foreach ($_value as $_key => $_code)
		{
			switch (SeedAllTable::checkSettings($_key))
			{
				case TRUE:
					SeedAllTable::del_db_variables($_key);
					SeedAllTable::init_db_variables($_code);
					break;
				case FALSE:
					SeedAllTable::init_db_variables($_code);
					break;
				default:
					break;
			}
		}
		return TRUE;
	}

	private function checkSettings($_value)
	{
		$_checkSettings = DB::table(Settings::$_table)->where('item', '=', $_value)->pluck('item');
		return ($_checkSettings)? TRUE : FALSE;
	}

	private function init_db_variables($_value)
	{
		foreach ($_value as $_per_value)
		{
			DB::table(Settings::$_table)->insert($_per_value);
		}
		//$this->installations->optimize_table(Settings::$_table);
		return TRUE;
	}

	private function del_db_variables($_value)
	{
		DB::table(Settings::$_table)->where('item', '=', $_value)->delete();
	}

	//----------------------------------------------------------------------//
	//	Seed Schema Tables - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Deprecate Functions - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Seed Function Tables - End
	//----------------------------------------------------------------------//
}
