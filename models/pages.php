<?php

use PhangoApp\PhaRouter\Routes;
use PhangoApp\PhaModels\Webmodel;
use PhangoApp\PhaModels\CoreFields\TextHTMLField;
use PhangoApp\PhaModels\CoreFields\I18nField;
use PhangoApp\PhaModels\CoreFields\CharField;
use PhangoApp\PhaModels\CoreFields\SlugifyField;
use PhangoApp\PhaModels\CoreFields\ForeignKeyField;
use PhangoApp\PhaModels\CoreFields\ImageField;
use PhangoApp\PhaI18n\I18n;

class page extends Webmodel {
    
	function __construct()
	{
		parent::__construct("page");
	}
	
	public function insert($post,  $safe_query = 0, $cache_name = '')
	{
	
		$post=$this->components['name']->add_slugify_i18n_post('name', $post);
	
		return parent::insert($post, $safe_query, $cache_name);
	
	}
	
	public function update($post,  $safe_query = 0, $cache_name = '')
	{
	
		$post=$this->components['name']->add_slugify_i18n_post('name', $post);
	
		return parent::update($post, $safe_query, $cache_name);
	
	}
	
}
$page=new page();

$html_field=new TextHTMLField();

$html_field->allowedtags=[];

$page->register('name', new I18nField(new CharField(600)), 1);
$page->register('text', new I18nField($html_field), 1);

$page->components['text']->parameters=[new PhangoApp\PhaModels\Forms\TextAreaEditor('text', '')];

SlugifyField::add_slugify_i18n_fields($page, 'name');

foreach(I18n::$arr_i18n as $lang_i18n)
{
	$page->components['name_'.$lang_i18n]->type='VARCHAR(255)';
	$page->components['name_'.$lang_i18n]->indexed=true;
}

$config_page=new Webmodel('config_page');
//Webmodel::$model['image_product']->register('idproduct', new ForeignKeyField(Webmodel::$model['product'], 11, $default_id=0, $name_field='title', $name_value='IdProduct'), 1);
$config_page->register('idpage', new ForeignKeyField($page, 11, 0, 'name', 'IdPage'), true);
$config_page->components['idpage']->name_field_to_field='name';

$image_page=new Webmodel('image_page');

$image_page->register('idpage', new ForeignKeyField($page, 11, 0, 'name', 'IdPage'), true);
$image_page->components['idpage']->name_field_to_field='name';

$image_page->register('image', new ImageField(Routes::$base_path.'/pages/images/', Routes::$root_url.'pages/images/'), true);

$image_page->register('description', new CharField(255), true);

?>
