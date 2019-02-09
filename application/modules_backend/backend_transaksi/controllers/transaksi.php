<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Admin
{
    private $_template = 'template_admin/main';
    private $_module_controller = 'backend_transaksi/transaksi/';

    private $_table_name 		= 'transaksi';
    private $_table_field_pref 	= '';
    private $_table_pk 			= 'trans_id';

    private $_page_title = 'IKM Lite : Admin Laporan Transaksi';
    private $_page_content_info = array(
        'title' => 'Data Admin Transaksi',
        'desc' => 'Grafik laporan Transaksi',
    );

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin_id')) {
            redirect('backend_login/login');
            exit();
        }
    }

    private function get_additional_field() {
        $additional_field = array(
            array(
                'field_name' 			=> 'butt_data',
                'just_info' 			=> true,
            ),
            array(
                'field_name' 			=> 'butt_value',
                'just_info' 			=> true,
            ),
            array(
                'field_name' 			=> 'butt_status',
                'just_info' 			=> true,
            ),
            array(
                'field_name'            => 'ktps_nama',
                'just_info'             => true,
            ),
        );

        return $additional_field;
    }

    private function get_show_column() {
        $column_list = array(
            array(
                'title_header_column' 	=> 'No.',
                'field_name' 			=> $this->_table_field_pref . 'butt_id',
                'show_no_static' 		=> true,
                'no_order'				=> 0,
            ),
            array(
                'title_header_column' 	=> 'Tanggal',
                'field_name' 			=> $this->_table_field_pref . 'trans_tgl',
                'no_order'				=> 1,
            ),
            array(
                'title_header_column' 	=> 'Status',
                'field_name' 			=> $this->_table_field_pref . 'butt_status',
                'no_order'				=> 2,
            ),
            array(
                'title_header_column'   => 'Ketidakpuasan',
                'field_name'            => $this->_table_field_pref . 'ktps_nama',
                'no_order'              => 2,
            ),
        );

        return $column_list;
    }

    function index()
    {
        $this->lists();
    }

    function lists()
    {
        $this->_data['ajax_lists'] = site_url($this->_module_controller . 'lists_ajax');
        $this->_data['ajax_form_add'] = site_url($this->_module_controller . 'add_ajax');
        $this->_data['ajax_form_edit'] = site_url($this->_module_controller . 'edit_ajax');
        $this->_data['ajax_action_delete'] = site_url($this->_module_controller . 'do_delete_ajax');

        $this->_data['info_page'] = $this->_page_content_info;

        //using lib template
        $this->template->set('title', $this->_page_title);
        $this->template->set('assets', $this->_data['assets']);
        $this->template->load($this->_template, 'lists', $this->_data);
    }

    function page_content_ajax()
    {
        $this->load->model('adminuser_model', 'adminuserx');
        $this->_data['option_user'] = $this->adminuserx->get_option();

        $this->_data['page_content_ajax'] = site_url($this->_module_controller . 'page_content_ajax');
        $this->_data['page_content_ajax_grid'] = site_url($this->_module_controller . 'page_content_ajax_grid');
        $this->_data['ajax_lists_filter'] = site_url('backend_transaksi/transaksi/lists_ajax_filter');

        $this->_data['info_page'] = $this->_page_content_info;

        $this->_data['dataChart'] = $this->getDataChart();
        $this->_data['tahun'] = date('Y');

        $this->load->view('lists', $this->_data);
    }

    function lists_ajax_filter()
    {
        $this->load->model('adminuser_model', 'adminuserx');
        $this->_data['option_user'] = $this->adminuserx->get_option();

        $this->_data['page_content_ajax'] = site_url($this->_module_controller . 'page_content_ajax');
        $this->_data['ajax_lists_filter'] = site_url('backend_transaksi/transaksi/lists_ajax_filter');

        $this->_data['info_page'] = $this->_page_content_info;

        $this->_data['trans_tgl'] = $this->input->post('trans_tgl');

        $this->_data['dataChart'] = $this->getDataChart($this->_data['trans_tgl']);
        $this->_data['tahun'] = date('Y');

        $this->load->view('lists_filter', $this->_data);
    }

    function page_content_ajax_grid() {
        $dateRange = $this->input->post('trans_tgl');
        $param = '';
        if(!empty($dateRange)) {
            list($range1, $range2) = explode(' - ', $dateRange);
            $param = "?range1=$range1&range2=$range2";
        }

        $this->_data['ajax_lists_grid'] 			= site_url($this->_module_controller . 'lists_ajax_grid' . $param);
        $this->_data['link_export_excel'] 			= site_url($this->_module_controller . 'page_export_excel' . $param);
        $this->_data['column_list'] = $this->get_show_column();
        $this->_data['info_page'] = $this->_page_content_info;
        $this->load->view('lists_grid', $this->_data);
    }

    //--- used by datatable source data -------
    function lists_ajax_grid() {
        $this->load->helper('mydatatable');
        $table 		= $this->db->dbprefix . $this->_table_name;
        $table      .= ' LEFT JOIN ' . $this->db->dbprefix . 'button ON (trans_butt_id = butt_id) ';
        $table 		.= ' LEFT JOIN ' . $this->db->dbprefix . 'ketidakpuasan ON (trans_ktps_id = ktps_id) ';
        $primaryKey = $this->_table_pk;
        $column_list = $this->get_show_column();
        $columns = array();
        $cnt = 0;
        foreach ($column_list as $key => $value) {
            $columns[] = array(
                'db' 				=> $value['field_name'],
                'dt' 				=> !empty($value['no_order']) ? $value['no_order'] : $cnt,
                'formatter' 		=> !empty($value['result_format']) ? $value['result_format'] : '',
                'show_no_static' 	=> !empty($value['show_no_static']) ? $value['show_no_static'] : '',
                'just_info' 		=> !empty($value['just_info']) ? $value['just_info'] : '',
                'alias' 			=> !empty($value['alias']) ? $value['alias'] : '',
            );
            $cnt++;
        }

        $additional_field = $this->get_additional_field();
        if(!empty($additional_field)) {
            foreach ($additional_field as $key => $value) {
                $columns[] = array(
                    'db' 				=> $value['field_name'],
                    'dt' 				=> !empty($value['no_order']) ? $value['no_order'] : $cnt,
                    'formatter' 		=> !empty($value['result_format']) ? $value['result_format'] : '',
                    'show_no_static' 	=> !empty($value['show_no_static']) ? $value['show_no_static'] : '',
                    'just_info' 		=> !empty($value['just_info']) ? $value['just_info'] : '',
                    'alias' 			=> !empty($value['alias']) ? $value['alias'] : '',
                );
                $cnt++;
            }
        }

        $whereResult 	= '';
        $whereAll = "DATE_FORMAT(trans_tgl, '%Y') = '" . date('Y') . "'";
        if(!empty($_GET['range1']) AND !empty($_GET['range2'])) {
            $whereAll = 'DATE_FORMAT(trans_tgl, "%Y-%m-%d") BETWEEN "'.$_GET['range1'].'" AND "'.$_GET['range2'].'"';
        }
        //$whereAll .= ' ORDER BY trans_tgl';
        generateDataTable($table, $primaryKey, $columns, $whereResult, $whereAll);
    }

    public function getDataChart($dateRange = '')
    {
        $arrColor = [
            'rgba(110,120,220,0.75)',
            'rgba(30,30,30,0.75)',
            'rgba(140,10,140,0.75)',
            'rgba(102,255,51,0.75)',
            'rgba(102,51,255,0.75)',
            'rgba(153,51,102,0.75)',
            'rgba(204,102,102,0.75)',
            'rgba(204,0,51,0.75)',
            'rgba(0,0,204,0.75)',
            'rgba(0,102,51,0.75)',
        ];

        $ret = [
            'status' => [],
            'detail' => [],
            'chart' => [],
            'color' => $arrColor,
            'month' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ]
        ];

        $where = "DATE_FORMAT(trans_tgl, '%Y') = '" . date('Y') . "'";
        if(!empty($dateRange)) {
            list($range1, $range2) = explode(' - ', $dateRange);
            $where = 'DATE_FORMAT(trans_tgl, "%Y-%m-%d") BETWEEN "'.$range1.'" AND "'.$range2.'"';
        }

        $sql = "
            SELECT trans_butt_id, butt_status, DATE_FORMAT(trans_tgl, '%m') as bulan, COUNT(trans_butt_id) as total 
            FROM transaksi 
            JOIN button ON (trans_butt_id = butt_id)
            WHERE $where
            GROUP BY DATE_FORMAT(trans_tgl, '%m'), trans_butt_id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            foreach ($res as $value) {
                $m = (int)$value['bulan'];
                $ret['detail'][$value['trans_butt_id']][$m] = $value['total'];
                $ret['status'][$value['trans_butt_id']] = $value['butt_status'];
            }

            foreach ($ret['status'] as $key => $value) {
                for ($i = 1; $i <= 12; $i++) {
                    $ret['chart'][$key][$i] = !empty($ret['detail'][$key][$i]) ? $ret['detail'][$key][$i] : 0;
                }
            }
        }
//        print_r($ret);
        return $ret;
    }

    function page_export_excel() {
        $filename = 'antrian_jcl_' . str_replace('-', '', date('Y-m-d')) . '.xls';
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename = " . $filename);
        header("Pragma: no-cache");
        header("Expires: 0");

        $this->_data['data_master'] = [];

        $where = "DATE_FORMAT(trans_tgl, '%Y') = '" . date('Y') . "'";
        if(!empty($_GET['range1']) AND !empty($_GET['range2'])) {
            $where = 'DATE_FORMAT(trans_tgl, "%Y-%m-%d") BETWEEN "'.$_GET['range1'].'" AND "'.$_GET['range2'].'"';
        }

        $sql = "
            SELECT * 
            FROM transaksi 
            JOIN button ON (trans_butt_id = butt_id)
            WHERE $where
            ORDER BY trans_tgl
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $this->_data['data_master'] = $query->result_array();
        }

        $this->template->set('title', 'IKM Lite : Export Excel Laporan Transaksi');
        $this->template->set('assets', $this->_data['assets']);
        $this->template->load('template_export/export_excel', 'lists_exportexcel', $this->_data);
    }

}

?>