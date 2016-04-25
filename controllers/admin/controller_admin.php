<?php

use PhangoApp\Phamodels\Webmodel;
use PhangoApp\PĥaI18n\I18n;

function PagesAdmin()
{
	settype($_GET['op'], 'integer');
	settype($_GET['IdPage'], 'integer');
	//load_libraries(array('generate_admin_ng', 'forms/textareabb', 'admin/generate_admin_class'));
	Webmodel::load_model('vendor/phangoapp/pages/models/pages');
	Webmodel::load_lang('phangoapp/pages');
    
	switch($_GET['op'])
	{
		default:
		/*
			?>
			<p><a href="<?php echo set_admin_link('pages', array('op' => 1)); ?>"><?php echo PhangoVar::$lang['pages']['config_home_page']; ?></a></p>
			<?php
			PhangoVar::$model['page']->create_form();
			PhangoVar::$model['page']->label=PhangoVar::$lang['pages']['pages'];
			
			PhangoVar::$model['page']->forms['name']->label=PhangoVar::$lang['common']['title'];
			PhangoVar::$model['page']->forms['text']->label=PhangoVar::$lang['common']['text'];
			
			PhangoVar::$model['page']->forms['text']->set_parameter(3, 'TextAreaBBForm');
			
			$arr_fields=array('name');
			$arr_fields_edit=array('name', 'text');
			$url_options=set_admin_link( 'pages', array());
			$admin=new GenerateAdminClass('page');
			
			$admin->set_url_post($url_options);
			$admin->arr_fields=$arr_fields;
			$admin->arr_fields_edit=$arr_fields_edit;
			
			$admin->show();
			
		break;
		
		case 1:
		
			PhangoVar::$model['config_page']->create_form();
			PhangoVar::$model['config_page']->forms['idpage']->label=PhangoVar::$lang['pages']['page_index'];
			
			
			?>
			<h3><?php echo PhangoVar::$lang['pages']['config_home_page']; ?></h3>
			<?php
		
			$url_options=set_admin_link( 'pages', array('op' => 1));
			
			$admin=new GenerateAdminClass('config_page');
			
			$admin->set_url_post($url_options);
			
			$admin->set_url_back( set_admin_link( 'pages', array()) );		
			
			$admin->show_config_mode();
		*/
		break;
	}
}
?>
