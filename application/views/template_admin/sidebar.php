<div class="scroll-sidebar">
    <ul id="sidebar-menu">
        <?php foreach($menu_sidebar as $key => $val) : ?>
            <li class="header"><span><?php echo $val['label']; ?></span></li>
            <?php if(!empty($val['child'])) : ?>
                <?php foreach($val['child'] as $key2 => $val2) : ?>
                    <li>
                        <a class="<?php echo ($val['label'] == 'Dashboard' ? 'content_dashboard' : 'content_ajax'); ?>" data-url="<?php echo (!empty($val2['url_link']) ? $val2['url_link'] : '#'); ?>" href="<?php echo (!empty($val2['url_link']) ? $val2['url_link'] : '#'); ?>" title="<?php echo $val2['label']; ?>">
                            <?php echo $val2['icon']; ?>
                            <span><?php echo $val2['label']; ?></span>
                        </a>
                        <?php if(!empty($val2['child'])) : ?>
                            <div class="sidebar-submenu">
                                <ul>
                                    <?php foreach($val2['child'] as $key3 => $val3) : ?>
                                        <li><a class="content_ajax" data-url="<?php echo (!empty($val3['url_link']) ? $val3['url_link'] : '#'); ?>" href="<?php echo (!empty($val3['url_link']) ? $val3['url_link'] : '#'); ?>" title="Buttons"><span><?php echo $val3['label']; ?></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul><!-- #sidebar-menu -->
</div>

<script type="text/javascript">
    $(function() { "use strict";
        $('.content_ajax').click(function(e){
            e.preventDefault();
            var url_action = $(this).data('url');
            $( "#page-content" ).load(url_action, function(){
                body_sizer();
            });
        });

        $('.content_dashboard').click(function(e){
            e.preventDefault();
            var url_action = $(this).data('url');
            window.location.href = url_action;
        });
    });
</script>