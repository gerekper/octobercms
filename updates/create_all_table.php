<?php namespace Devnull\Main\Updates;

use Db;
use Illuminate\Support\Facades\Schema;
use Devnull\Main\Classes\InstallMain;
use October\Rain\Database\Updates\Migration;
use Devnull\Main\Models\Breadcrumb;
use Devnull\Main\Models\Meta;
use Devnull\Main\Models\MetaDirective;
use Devnull\Main\Models\MetaListDirective;
use Devnull\Main\Models\Robot;
use Devnull\Main\Models\RobotDirective;
use Devnull\Main\Models\RobotAgent;
use Devnull\Main\Models\RobotLog;
use Devnull\Main\Models\Human;
use Devnull\Main\Models\HumanInfo;
use Devnull\Main\Models\HumanConfig;
use Devnull\Main\Models\Menu;

class CreateAllTable extends Migration
{
	//----------------------------------------------------------------------//
	//	Construct Functions - Start
	//----------------------------------------------------------------------//

	function __construct()
	{
		$this->_table_engine                    =   'InnoDB';
		$this->_main_breadcrumbs                =   Breadcrumb::$_table;
		$this->_main_meta                       =   Meta::$_table;
		$this->_main_meta_directive             =   MetaDirective::$_table;
		$this->_main_meta_ldirective            =   MetaListDirective::$_table;
		$this->_main_robot                      =   Robot::$_table;
		$this->_main_robot_directive            =   RobotDirective::$_table;
		$this->_main_robot_agent                =   RobotAgent::$_table;
		$this->_main_robot_log                  =   RobotLog::$_table;
		$this->_main_human                      =   Human::$_table;
		$this->_main_human_info                 =   HumanInfo::$_table;
		$this->_main_human_config               =   HumanConfig::$_table;
		$this->_main_menus                      =   Menu::$_table;

		//$this->_main_cookies                    =   Cookies::$_table;
		//$this->_main_bakery_bakery              =   Bakery::$_table;
		//$this->_main_bakery_category            =   BakeryCategory::$_table;
		//$this->_main_bakery_category_listing    =   BakeryCategoryListing::$_table;
		//$this->_main_bakery_locationsg          =   BakeryLocationsg::$_table;
		//$this->_main_bakery_locationsg_district =   BakeryLocationsgDistrict::$_table;
		//$this->_main_bakery_locationsg_locale   =   BakeryLocationsgLocale::$_table;
		//$this->_main_bakery_postalsg            =   BakeryPostalSG::$_table;

		$this->_down =   [
			$this->_main_breadcrumbs, $this->_main_meta, $this->_main_meta_directive, $this->_main_meta_ldirective, $this->_main_robot,
			$this->_main_robot_directive, $this->_main_robot_agent, $this->_main_human, $this->_main_human_info, $this->_main_human_config,
			$this->_main_robot_log, $this->_main_menus
		];

		$this->installations        =   new InstallMain();
	}

	//----------------------------------------------------------------------//
	//	Main Functions - Start
	//----------------------------------------------------------------------//

	public function up()
	{
		$this->down($this->_down);
		$this->install_main_breadcrumb();
		$this->install_main_meta();
		$this->install_main_meta_directive();
		$this->install_main_meta_ldirective();
		$this->install_main_robot();
		$this->install_main_robot_directive();
		$this->install_main_robot_agent();
		$this->install_main_robot_log();
		$this->install_main_human();
		$this->install_main_human_info();
		$this->install_main_human_config();
		$this->install_main_menus();
	}

	public function down() { foreach($this->_down as $_downing) {$this->installations->remove_table($_downing);}}

	//----------------------------------------------------------------------//
	//	Schema Table - Start
	//----------------------------------------------------------------------//

	//----------------------------------------------------------------------//
	//	Breadcrumb Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_breadcrumb()
	{
		$this->installations->remove_table($this->_main_breadcrumbs);
		Schema::create($this->_main_breadcrumbs, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('page_name', 100);
			$table->string('page_child', 100);
			$table->string('page_baseFileName', 200);
			$table->string('class', 50)->default('pg pg-home');
			$table->string('href', 100);
			$table->enum('type', array('_blank', '_parent', '_self', '_top'));
			$table->tinyInteger('hide')->default(0);
			$table->tinyInteger('disabled')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
		$this->install_main_breadcrumb_set();
	}

	private function install_main_breadcrumb_set()
	{
		DB::Statement("ALTER TABLE `". $this->_main_breadcrumbs . "` CHANGE `type` `type` SET('_blank','_parent', '_self', '_top') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '_self';");
	}

	//----------------------------------------------------------------------//
	//	SEO Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_meta()
	{
		$this->installations->remove_table($this->_main_meta);
		Schema::create($this->_main_meta, function ($table)
		{
			$this->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('page', 100);
			$table->tinyInteger('status');
			$table->timestamps();
		});
	}

	private function install_main_meta_directive()
	{
		$this->installations->remove_table($this->_main_meta_directive);
		Schema::create($this->_main_meta_directive, function($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->integer('meta_id')->default('0');
			$table->string('type', 250);
			$table->string('property', 250);
			$table->string('content', 250)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->integer('position')->nullable();
			$table->string('category', 100)->nullable();
			$table->timestamps();
		});
	}

	private function install_main_meta_ldirective()
	{
		$this->installations->remove_table($this->_main_meta_ldirective);
		Schema::create($this->_main_meta_ldirective, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('type',100);
			$table->string('property', 250);
			$table->string('content', 250)->nullable();
			$table->string('category', 100)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
	}

	//----------------------------------------------------------------------//
	//	Robot Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_robot()
	{
		$this->installations->remove_table($this->_main_robot);
		Schema::create($this->_main_robot, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('agent');
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
	}

	private function install_main_robot_directive()
	{
		$this->installations->remove_table($this->_main_robot_directive);
		Schema::create($this->_main_robot_directive, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->integer('robot_id')->default(0);
			$table->integer('position')->default(0);
			$table->enum('type', array('Disallow', 'Allow'));
			$table->string('data', 250);
			$table->timestamps();
		});
		$this->install_main_robot_directive_set();
	}

	private function install_main_robot_directive_set()
	{
		DB::Statement("ALTER TABLE `". $this->_main_robot_directive . "` CHANGE `type` `type` SET('Disallow','Allow') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Disallow';");
	}

	private function install_main_robot_agent()
	{
		$this->installations->remove_table($this->_main_robot_agent);
		Schema::create($this->_main_robot_agent, function ($table)
		{
			$table->engine  =   $this->_table_engine;
			$table->increments('id')->index();
			$table->string('name', 200);
			$table->string('desc', 255);
			$table->string('nameId', 200);
			$table->string('details_url', 250)->nullable();
			$table->string('cover_url', 250)->nullable();
			$table->string('owner_name', 100)->nullable();
			$table->string('owner_url', 250)->nullable();
			$table->string('owner_email', 100)->nullable();
			$table->string('ostatus', 100)->nullable();
			$table->string('purpose', 100)->nullable();
			$table->string('type', 100)->nullable();
			$table->string('platform', 100)->nullable();
			$table->string('avail', 100)->nullable();
			$table->string('excl', 100)->nullable();
			$table->string('excl_agent', 250)->nullable();
			$table->string('noindex', 100)->nullable();
			$table->string('nofollow', 100)->nullable();
			$table->string('host', 100)->nullable();
			$table->string('from', 100)->nullable();
			$table->string('user_agent', 250)->nullable();
			$table->string('lang', 100)->nullable();
			$table->string('history', 250)->nullable();
			$table->string('env', 100)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
	}

	private function install_main_robot_log()
	{
		$this->installations->remove_table($this->_main_robot_log);
		Schema::create($this->_main_robot_log, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('useragent', 255);
			$table->biginteger('addr')->nullable();
			$table->string('remote_host', 255)->nullable();
			$table->string('remote_port', 100)->nullable();
			$table->string('request_method', 255)->nullable();
			$table->biginteger('request_time')->nullable();
			$table->bigInteger('request_time_float')->nullable();
			$table->string('query_string', 255)->nullable();
			$table->string('http_host', 200)->nullable();
			$table->string('http_referrer', 200)->nullable();
			$table->tinyInteger('is_robot')->nullable()->default(0);
			$table->tinyInteger('is_human')->nullable()->default(0);
			$table->timestamps();
		});
	}

	//----------------------------------------------------------------------//
	//	Humans.txt Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_human()
	{
		$this->installations->remove_table($this->_main_human);
		Schema::create($this->_main_human, function ($table)
		{
			$table->enging = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('attribution', 200);
			$table->string('others', 200)->nullable()->default(null);
			$table->tinyInteger('status')->default(true);
			$table->timestamps();
		});
	}

	private function install_main_human_info()
	{
		$this->installations->remove_table($this->_main_human_info);
		Schema::create($this->_main_human_info, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->integer('human_id')->default(0);
			$table->integer('position')->default(0);
			$table->string('field', 255);
			$table->string('value', 255);
			$table->string('others', 255)->nullable();
			$table->timestamps();
		});
	}

	private function install_main_human_config()
	{
		$this->installations->remove_table($this->_main_human_config);
		Schema::create($this->_main_human_config, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->string('title', 100);
			$table->string('desc', 255);
			$table->text('value', 255);
			$table->string('url', 255)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
	}

	//----------------------------------------------------------------------//
	//	Menu Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_menus()
	{
		$this->installations->remove_table($this->_main_menus);
		Schema::create($this->_main_menus, function ($table)
		{
			$table->engine = $this->_table_engine;
			$table->increments('id')->index();
			$table->integer('parent_id')->nullable();
			$table->string('title', 255);
			$table->string('description', 255);
			$table->string('url', 255)->nullable();
			$table->integer('nest_left');
			$table->integer('nest_right');
			$table->integer('nest_depth');
			$table->tinyInteger('is_external')->default(0);
			$table->string('link_target', 255)->default('_self');
			$table->integer('enabled')->default(1);
			$table->string('parameters', 255)->nullable();
			$table->string('query_string', 255)->nullable();
			$table->timestamps();
		});
	}



	//----------------------------------------------------------------------//
	//	SEO Schema Table - Start
	//----------------------------------------------------------------------//

	private function install_main_bakery_bakery()
	{

	}

	private function install_main_bakery_category()
	{

	}

	private function install_main_bakery_category_listing()
	{

	}

	private function install_main_bakery_locationsg()
	{

	}

	private function install_main_bakery_locationsg_district()
	{

	}

	private function install_main_bakery_locationsg_locale()
	{

	}

	private function install_main_bakery_postalSG()
	{

	}

	private function install_main_bakery_company()
	{

	}

	private function install_main_bakery_pricelist()
	{

	}

	private function install_main_bakery_access()
	{}

	private function install_main_bakery_bookmark()
	{

	}

	private function install_main_bakery_campaign()
	{

	}

	private function install_main_bakery_ctb()
	{}

	private function install_main_bakery_checklist()
	{}

	private function install_main_bakery_counter()
	{

	}

	private function install_main_bakery_countertop()
	{

	}

	private function install_main_bakery_customer_support()
	{}

	private function install_main_bakery_dropship()
	{}

	private function install_main_bakery_flag()
	{

	}

	private function install_main_bakery_follow()
	{}

	private function install_main_bakery_gyft()
	{}

	private function install_main_bakery_heartbeat()
	{}

	private function install_main_bakery_horoscope()
	{}

	private function install_main_bakery_invite()
	{}

	private function install_main_bakery_log()
	{}

	private function install_main_bakery_planner()
	{}

	private function install_main_bakery_pos(){}

	private function install_main_bakery_votepolls(){}

	private function install_main_bakery_postcard(){}

	private function install_main_bakery_relationship() {}

	private function install_main_bakery_report(){}

	private function install_main_bakery_sedapbar(){}

	private function install_main_bakery_stock(){}

	private function install_main_bakery_testimonial(){}

	private function install_main_bakery_transporter(){}

	private function install_main_bakery_versionhistory(){}

	private function install_main_bakery_space(){}

	private function install_main_bakery_points() {}

	private function install_main_bakery_hashtag() {}

	private function install_main_bakery_hashtaglist() {}

	private function install_main_bakery_reputation() {}

	//----------------------------------------------------------------------//
	//	Undeveloped functions
	//----------------------------------------------------------------------//
}