<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {
	var $_data;
	
	function __construct(){
		parent::__construct();

		$this->load->helper('main');
		$this->load->helper('cookie');
	}
}

class MY_Admin extends MY_Controller {
	var $_data;
	
	function __construct(){
		parent::__construct();

		/* Model Load */
		$this->load->model('adminuser_model','users');
		
		/* Assets Load */
		$this->config->load('assets');
		
		$path_web = $this->config->item('backstage');
		
		$this->_data['assets'] 	= site_url($path_web['assets']);

		$arrUserLevel = array(
			'Superadmin',
			'Admin',
			'Counter',
			'Demo'
		);
		
		/* Login Checking */
		$this->_data['is_admin_logged_in'] 	= $this->session->userdata('is_admin_logged_in');
		$this->_data['admin_username'] 		= $this->session->userdata('admin_username');
        $this->_data['admin_image'] 		= site_url('assets/backstage/upload/'.$this->session->userdata('admin_image'));

        if (!@getimagesize($this->_data['admin_image'])) $this->_data['admin_image'] = site_url('assets/backstage/upload/blank_user.jpg');

        $this->_data['admin_id'] 			= $this->session->userdata('admin_id');
		$this->_data['admin_userlevel'] 	= !empty($arrUserLevel[$this->session->userdata('admin_userlevel')]) ? $arrUserLevel[$this->session->userdata('admin_userlevel')] : '';
		$this->_data['is_admin_banned'] 	= $this->session->userdata('is_admin_banned');
		
		/* Url Home */
		$this->_data['url_home'] 			= site_url('backend_admin/admin/lists');

		$this->_data['url_login'] 		= site_url('backend_login/login');
		$this->_data['url_logout'] 		= site_url('backend_logout/logout');

		$this->_data['menu_sidebar'] 	= array(
			array(
				'label' => 'Menu',
                'icon' => '<i class="glyph-icon icon-linecons-diamond"></i>',
				'child'	=> array(
					array(
						'label' => 'Button',
                        'url_link' => site_url('backend_button/button/page_content_ajax'),
                        'icon' => '<i class="glyph-icon icon-dot-circle-o"></i>',
					),
					array(
						'label' => 'Setting',
                        'url_link' => site_url('backend_setting/setting/page_content_ajax'),
                        'icon' => '<i class="glyph-icon icon-elusive-cog"></i>',
					),
                    array(
                        'label' => 'Laporan Transaksi',
                        'url_link' => site_url('backend_transaksi/transaksi/page_content_ajax'),
                        'icon' => '<i class="glyph-icon icon-line-chart"></i>',
                    ),
                    array(
                        'label' => 'Admin User',
                        'url_link' => site_url('backend_admin/admin/page_content_ajax'),
                        'icon' => '<i class="glyph-icon icon-typicons-users-outline"></i>',
                    ),
//                    array(
//                        'label' => 'Admin User Level',
//                        'url_link' => site_url('backend_adminlevel/adminlevel/page_content_ajax'),
//                        'icon' => '<i class="glyph-icon icon-linecons-diamond"></i>',
//                    ),
				),
			),
		);
	}
}

?>