<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>/widgets/datatable/datatable-tabletools.js"></script>

<script type="text/javascript">
    myowndatatable = '';
    $(document).ready(function() {
        myowndatatable = $('#datatable-example').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": '<?php echo $ajax_lists_grid; ?>',
            "columnDefs": [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }
            ],
            "order": [[ 1, 'asc' ]]
        });
    });

    $(document).ready(function() {
        $('.dataTables_filter input').attr("placeholder", "Search...");
    });

    function refreshTable() {
        //$('#datatable-example_wrapper ul.pagination li:eq(1)>a').trigger('click');
        myowndatatable.fnClearTable(0);
        myowndatatable.fnDraw();
    }

</script>

<div class="col-sm-12">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
        <thead>
        <tr>
            <?php foreach($column_list as $val) : ?>
                <th><?php echo $val['title_header_column']; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
    </table>
    <div class="form-group">
        <div class="col-sm-6 col-md-offset-6 text-right">
            <a href="<?php echo $link_export_excel; ?>" class="btn btn-blue-alt">Excel</a>
        </div>
    </div>
</div>