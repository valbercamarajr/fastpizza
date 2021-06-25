<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<section class="dashboard_row">
    <div class="box box-4 radius boxshadow bg-white">
        <div class="box_header line_dark"><h1>Este é o título da box</h1></div>
        <div class="box_content">Este é o conteúdo da box</div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="box_header"><h1>Este é o título da box</h1></div>
        <div class="box_content">Este é o conteúdo da box</div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="box_header"><h1>Este é o título da box</h1></div>
        <div class="box_content">Este é o conteúdo da box</div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="box_header"><h1>Este é o título da box</h1></div>
        <div class="box_content">Este é o conteúdo da box</div>
    </div>
</section>
<section class="dashboard_row">
    <div class="box box-4 radius boxshadow bg-white">
        <div class="dashboard_widget">
            <div class="dashboard_widget_icon"><i class="fa fa-envelope-open"></i></div>
            <div class="dashboard_widget_content">
                <h2>Emails</h2>
                Mensagens em atraso
            </div>
        </div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="dashboard_widget">
            <div class="dashboard_widget_icon"><i class="fa fa-envelope"></i></div>
            <div class="dashboard_widget_content">
                <h2>Emails</h2>
                Mensagens em atraso
            </div>
        </div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="dashboard_widget">
            <div class="dashboard_widget_icon">130</div>
            <div class="dashboard_widget_content">
                <h2>Emails</h2>
                Mensagens em atraso
            </div>
        </div>
    </div>
    <div class="box box-4 radius boxshadow bg-white">
        <div class="dashboard_widget">
            <div class="dashboard_widget_icon"><i class="fa fa-envelope"></i></div>
            <div class="dashboard_widget_content">
                <h2>Emails</h2>
                Mensagens em atraso
            </div>
        </div>
    </div>
   
</section>
<div class="clear"></div>
<section>
    <div class="box radius bg-white">
        <div class="dashboard_panel">
            <h1>Simple Sidebar</h1>
            <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
            <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
            <button id="myBtn" data-modal="myModal" class="btn btn-icon btn-sm btn-green radius modal-open"><i class="fa fa-hand-o-up"></i>Modal</button>
            <button id="myBtn" data-modal="myModal2" class="btn btn-icon btn-sm btn-blue radius modal-open"><i class="fa fa-hand-o-up"></i>Modal</button>
            <button id="myBtn" class="btn btn-icon btn-sm btn-yelow radius j_notification_box_plugin_open"><i class="fa fa-hand-o-up"></i>Modal</button>
            <button id="myBtn" class="btn btn-icon btn-sm btn-red radius"><i class="fa fa-hand-o-up"></i>Modal</button>
            <button id="myBtn" class="btn btn-icon btn-sm btn-gray radius"><i class="fa fa-hand-o-up"></i>Modal</button>
        </div>

    </div>
</section>
