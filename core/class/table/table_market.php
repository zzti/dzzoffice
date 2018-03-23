<?php
/*
 * @copyright   Leyun internet Technology(Shanghai)Co.,Ltd
 * @license     http://www.dzzoffice.com/licenses/license.txt
 * @package     DzzOffice
 * @link        http://www.dzzoffice.com
 * @author      zyx(zyx@dzz.cc)
 */

if(!defined('IN_DZZ')) {
	exit('Access Denied');
}

class table_market extends dzz_table
{
	public function __construct() {

		$this->_table = 'market';
		$this->_pk    = 'mid';

		parent::__construct();
	}
	public function fetch_by_mid($mid,$width=800,$height=500,$original=0){
		$app=parent::fetch($mid);
		$version=DB::fetch_first("select * from %t where mid=%d order by version_num desc limit 1",array('market_version',$mid)); 
		if($version && $field=C::t('market_field')->fetch($version['id'])){
			$app['desc']=$field['desc'];
			$app['pics']=C::t('market_field')->fetch_pic_by_mid($version['id'],$width,$height,$original);
		}
		$app['coverimg']=C::t('attachment')->getThumbByAid($app['cover'],236,136,0);
		 
		return $app;
	}
	public function delete_by_mid($mid){
		if(parent::delete($mid)){
			C::t('market_field')->delete_by_mid($mid);
			return true;
		}
		return false;
	}
}

?>
