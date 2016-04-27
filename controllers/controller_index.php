<?php

use PhangoApp\PhaRouter\Routes;
use PhangoApp\PhaRouter\Controller;
use PhangoApp\PhaModels\Webmodel;
use PhangoApp\PhaModels\CoreFields\I18nField;
use PhangoApp\PhaView\View;

Webmodel::load_model('vendor/phangoapp/pages/models/pages');

class IndexController extends Controller
{
	public function home($id=0)
	{
	
		if($id===0)
		{
		
			$arr_config=Webmodel::$model['config_page']->select_a_row_where([], 1);
			
			settype($arr_config['idpage'], 'integer');
			
			if($arr_config['idpage']>0)
			{
				
				$id=$arr_config['idpage'];
			
			}
			else
			{
			
				die;
			
			}
		
		}
        
        $check_id=$id;
        
        settype($check_id, 'integer');
        
        if($check_id==false)
        {
            
            if(!isset($_SESSION['language']))
            {
                
                $_SESSION['language']=PhangoApp\PhaI18n\I18n::$language;
                
            }
            
            Webmodel::$model['page']->set_conditions(['WHERE `name_'.$_SESSION['language'].'`=?', [$id]]);
            
            $arr_page=Webmodel::$model['page']->select_a_row_where();
            
        }
        else
        {
            
            $arr_page=Webmodel::$model['page']->select_a_row($id);
            
        }
		
		
        if($arr_page)
        {
            $title=I18nField::show_formatted($arr_page['name']);
            
            $content=I18nField::show_formatted($arr_page['text']);
            
            $cont_index=View::load_view([$title, $content], 'content');
            
            echo View::load_view([$title, $cont_index], 'home');
	
        }

	}

}
?>
