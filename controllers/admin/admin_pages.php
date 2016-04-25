<?php

use PhangoApp\Phamodels\Webmodel;
use PhangoApp\PhaI18n\I18n;
use PhangoApp\PhaLibs\AdminUtils;
use PhangoApp\PhaLibs\GenerateAdminClass;
use PhangoApp\PhaLibs\FatherLinks;

function PagesAdmin()
{
	settype($_GET['op'], 'integer');
	settype($_GET['IdPage'], 'integer');
	//load_libraries(array('generate_admin_ng', 'forms/textareabb', 'admin/generate_admin_class'));
	Webmodel::load_model('vendor/phangoapp/pages/models/pages');
	I18n::load_lang('phangoapp/pages');
    
    $arr_links[0]=[I18n::lang('phangoapp/pages', 'pages_home', 'Pages Home'), AdminUtils::set_admin_link('pages', array('op' => 0))];
    
    
	switch($_GET['op'])
	{
		default:
        
            settype($_GET['IdPage'], 'integer');
        
            echo '<p>'.implode(' &gt;&gt; ', FatherLinks::show($_GET['op'], $arr_links)).'</p>';
		
			?>
			<p><a href="<?php echo AdminUtils::set_admin_link('pages', array('op' => 1)); ?>"><?php echo I18n::lang('phangoapp/pages', 'config_home_page', 'Configure homepage'); ?></a></p>
			<?php
            
            //Webmodel::$model['page']->components['text']->form='PhangoApp\PhaModels\Forms\TextAreaEditor';
            
            
            
			Webmodel::$model['page']->create_forms();
			Webmodel::$model['page']->label=I18n::lang('pages', 'pages', 'Pages');
			
			Webmodel::$model['page']->forms['name']->label=I18n::lang('common', 'title', 'Title');
			Webmodel::$model['page']->forms['text']->label=I18n::lang('common', 'text', 'Text');
            
            Webmodel::$model['page']->forms['text']->type_form->load_image_url=AdminUtils::set_admin_link('pages', ['op' => 3, 'idpage' => $_GET['IdPage']]);
			
			//Webmodel::$model['page']->forms['text']->set_parameter(3, 'TextAreaBBForm');
			
			$arr_fields=array('name');
			$arr_fields_edit=array('name', 'text');
			$url_options=AdminUtils::set_admin_link( 'pages', array());
			$admin=new GenerateAdminClass(Webmodel::$model['page'], $url_options);
			
			$admin->list->arr_fields=$arr_fields;
			$admin->arr_fields_edit=$arr_fields_edit;
			$admin->list->options_func='page_options';
            
			$admin->show();
			
		break;
		
		case 1:
        
            $arr_links[1]=[I18n::lang('phangoapp/pages', 'config_home_page', 'Configure homepage'), AdminUtils::set_admin_link('pages', array('op' => 1))];
        
            echo '<p>'.implode(' &gt;&gt; ', FatherLinks::show($_GET['op'], $arr_links)).'</p>';
		
			Webmodel::$model['config_page']->create_forms();
			Webmodel::$model['config_page']->forms['idpage']->label=I18n::lang('pages', 'page_index', 'Home page');
			
			
			?>
			<h3><?php echo I18n::lang('pages', 'config_home_page', 'Config home page'); ?></h3>
			<?php
		
			$url_options=AdminUtils::set_admin_link( 'pages', array('op' => 1));
			
			$admin=new GenerateAdminClass(Webmodel::$model['config_page'], $url_options);
			
			//$admin->set_url_back( set_admin_link( 'pages', array()) );		
			
			$admin->show_config();
		
		break;
        
        case 2:
        
            settype($_GET['idpage'], 'integer');
            
            Webmodel::$model['image_page']->components['idpage']->form='PhangoApp\PhaModels\Forms\HiddenForm';
            Webmodel::$model['image_page']->components['idpage']->default_value=$_GET['idpage'];
        
            $arr_links[2]=[I18n::lang('common', 'add_image', 'Add Image'), AdminUtils::set_admin_link('pages', array('op' => 2, 'idpage' => $_GET['idpage']))];
            
            echo '<p>'.implode(' &gt;&gt; ', FatherLinks::show($_GET['op'], $arr_links)).'</p>';
            
            ?>
			<h3><?php echo I18n::lang('common', 'add_image', 'Add Image'); ?></h3>
			<?php
		
			$url_options=AdminUtils::set_admin_link( 'pages', array('op' => 2, 'idpage' => $_GET['idpage']));
			
			$admin=new GenerateAdminClass(Webmodel::$model['image_page'], $url_options);
			
            $admin->list->where_sql=['WHERE image_page.idpage=?', [$_GET['idpage']]];
            
			$admin->show();
            
            
        
        break;
        
        case 3:
        
            AdminUtils::$show_admin_view=false;
            
            Webmodel::$model['image_page']->set_conditions(['where idpage=?', [$_GET['idpage']]]);
            
            $arr_result=[];
            
            $query=Webmodel::$model['image_page']->select(['image', 'description']);
            
            while(list($image, $description)=Webmodel::$model['page']->fetch_row($query))
            {
                
                $image_url=Webmodel::$model['image_page']->components['image']->show_image_url($image);
                
                $arr_result[]=['image' => $image_url];
                
            }
        
            ob_clean();
        
            header('Content-type: text/plain');
        
            echo json_encode($arr_result);
            
            die;
        
        break;
	}
}
function page_options($url_options, $model_name, $id, $row_id)
{
    
    $options=PhangoApp\PhaLibs\SimpleList::BasicOptionsListModel($url_options, $model_name, $id);
    
    $options[]='<a href="'.AdminUtils::set_admin_link( 'pages', array('op' => 2, 'idpage' => $id)).'">'.I18n::lang('common', 'add_image', 'Add Image').'</a>';
    
    return $options;
    
}

?>
