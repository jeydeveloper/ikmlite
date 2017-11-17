<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Admin
{
    private $_template = 'template_admin/main';
    private $_module_controller = 'backend_transaksi/transaksi/';

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

    public function getDataChart($dateRange = '')
    {
        $arrColor = [
            'rgba(110,120,220,0.75)',
            'rgba(30,30,30,0.75)',
            'rgba(140,10,140,0.75)',
            'rgba(50,50,50,0.75)',
            'rgba(100,100,200,0.75)',
            'rgba(10,10,10,0.75)',
            'rgba(25,25,25,0.75)',
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
            $where = 'trans_tgl BETWEEN "'.$range1.'" AND "'.$range2.'"';
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

}

?>