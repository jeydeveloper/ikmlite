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

<div class="col-sm-12">
    <?php if (!empty($dataChart['status'])): ?>
        <div class="chart-legend">
            <ul>
                <?php $cnt = 0;
                foreach ($dataChart['status'] as $key => $value): ?>
                    <li>
                        <span style="background-color:<?php echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); ?>"></span><?php echo $value; ?>
                    </li>
                    <?php $cnt++; endforeach; ?>
            </ul>
        </div>
        <canvas id="canvas-1"></canvas>
        <script>
            $(function () {
                /* Bar */

                var barChartData = {
                    labels: ["<?php echo join('","', $dataChart['month']);?>"],
                    datasets: [
                        <?php $cnt = 0; foreach ($dataChart['status'] as $key => $value): ?>
                        {
                            fillColor: "<?php echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); ?>",
                            strokeColor: "<?php echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); ?>",
                            highlightFill: "<?php echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); ?>",
                            highlightStroke: "<?php echo(!empty($dataChart['color'][$cnt]) ? $dataChart['color'][$cnt] : 'rgba(30,30,30,0.75)'); ?>",
                            data: [<?php echo join(',', $dataChart['chart'][$key]); ?>]
                        },
                        <?php $cnt++; endforeach; ?>
                    ]

                }
                var ctx = document.getElementById("canvas-1").getContext("2d");
                window.myBar = new Chart(ctx).Bar(barChartData, {
                    responsive: true
                });

            })
        </script>
    <?php else: ?>
        <p>Oops.. data chart is empty!</p>
    <?php endif; ?>
</div>