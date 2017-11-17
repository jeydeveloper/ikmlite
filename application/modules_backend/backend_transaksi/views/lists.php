<script type="text/javascript" src="<?php echo $assets; ?>/widgets/modal/modal.js"></script>

<script type="text/javascript" src="<?php echo $assets; ?>/widgets/jgrowl-notifications/jgrowl.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/jgrowl-notifications/jgrowl-demo.js"></script>

<!-- Data tables -->
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-tabletools.js"></script>

<!-- Bootstrap Daterangepicker -->
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/daterangepicker/moment.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/daterangepicker/daterangepicker-demo.js"></script>

<!-- Chart.js -->

<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-core.js"></script>

<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-bar.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-doughnut.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-line.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-polar.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/charts/chart-js/chart-radar.js"></script>

<!-- Data tables -->
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-tabletools.js"></script>

<style>
    .chart-legend ul {
        list-style: none;
    }

    .chart-legend li {
        float: left;
        margin-right: 10px;
    }

    .chart-legend li span {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }
</style>

<div id="page-title">
    <h2><?php echo $info_page['title']; ?></h2>
    <p><?php echo $info_page['desc']; ?> tahun <?php echo $tahun; ?></p>
</div>

<div id="panel_list">
    <div class="panel">
        <div class="panel-body">
            <form method="post" class="form-horizontal bordered-row" id="form_datacontent_filter">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-sm-9">
                                <input type="text" name="trans_tgl" id="daterangepicker-example" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div style="width:100%;height:40px;">
                            <button style="width:100%;height:100%;font-size:24px;" class="btn btn-success" id="btn_preview">View</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel">
        <div class="panel-body">

            <h3 class="title-hero">Grafik</h3>
            <div id="datacontent_filter" class="example-box-wrapper"></div>

            <h3 class="title-hero">Data Grid</h3>
            <div id="datacontent_filter_grid" class="example-box-wrapper"></div>

            <!--<div id="datacontent_filter_wtc" class="example-box-wrapper">
                <div class="col-sm-12">
                    <?php /*if (!empty($dataChart['status'])): */?>
                        <div class="chart-legend">
                            <ul>
                                <?php /*$cnt = 0;
                                foreach ($dataChart['status'] as $key => $value): */?>
                                    <li>
                                        <span style="background-color:<?php /*echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); */?>"></span><?php /*echo $value; */?>
                                    </li>
                                    <?php /*$cnt++; endforeach; */?>
                            </ul>
                        </div>
                        <canvas id="canvas-1"></canvas>
                        <script>
                            $(function () {
                                /* Bar */

                                var barChartData = {
                                    labels: ["<?php /*echo join('","', $dataChart['month']);*/?>"],
                                    datasets: [
                                        <?php /*$cnt = 0; foreach ($dataChart['status'] as $key => $value): */?>
                                        {
                                            fillColor: "<?php /*echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); */?>",
                                            strokeColor: "<?php /*echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); */?>",
                                            highlightFill: "<?php /*echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); */?>",
                                            highlightStroke: "<?php /*echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); */?>",
                                            data: [<?php /*echo join(',', $dataChart['chart'][$key]); */?>]
                                        },
                                        <?php /*$cnt++; endforeach; */?>
                                    ]

                                }
                                var ctx = document.getElementById("canvas-1").getContext("2d");
                                window.myBar = new Chart(ctx).Bar(barChartData, {
                                    responsive: true
                                });

                            })
                        </script>
                    <?php /*else: */?>
                        <p>Oops.. data chart is empty!</p>
                    <?php /*endif; */?>
                </div>
            </div>-->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $( "#datacontent_filter" ).load('<?php echo $ajax_lists_filter; ?>', function(){
            console.log('hai');
        });

        $( "#datacontent_filter_grid" ).load('<?php echo $page_content_ajax_grid; ?>', function(){
            console.log('hai');
        });

        $('#btn_preview').click(function(e) {
            e.preventDefault();
            var param = {
                'url_ajax_action'   : '<?php echo $ajax_lists_filter; ?>',
                'parameter'         : $('#form_datacontent_filter').serialize(),
                'data_type'         : 'html',
                'callback'          : function(data) {
                    $('#datacontent_filter').empty().append(data);
                }
            };
            MYAPP.doAjax.process(param.url_ajax_action, param.parameter, param.callback, param.data_type);

            var param = {
                'url_ajax_action'   : '<?php echo $page_content_ajax_grid; ?>',
                'parameter'         : $('#form_datacontent_filter').serialize(),
                'data_type'         : 'html',
                'callback'          : function(data) {
                    $('#datacontent_filter_grid').empty().append(data);
                }
            };
            MYAPP.doAjax.process(param.url_ajax_action, param.parameter, param.callback, param.data_type);
        });
    });
</script>