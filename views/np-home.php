<?php 
    $reqMsg = null;
    if(!$this->configComplet()){
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Push Notificações App Alcance</h1>
        <hr class="wp-header-end">
        <h3>Finalize a Configuração do Plugin para poder Continuar</h3>
    </div>
<?php } else { ?>
    <?php

        $req = new NP_Onesignal();
        $info = $req->getInfoApp();
        $info2 = $req->listNotifications(1);

        if(isset($_POST['push_title'])) // Se existir o array post, pq ele não retorna undefined index.
        {

            $push = new NP_Push($_POST['push_title'],$_POST['push_msg']);
            $reqMsg = $push->sendPush();
            if(isset($reqMsg->errors)){
                $reqMsg = null;
            }

        }
    ?>
<div class="wrap">
    <h1 class="wp-heading-inline">Push Notificações App Alcance</h1>
    <hr class="wp-header-end">
    <div id="welcome-panel" class="welcome-panel">
        <div class="welcome-panel-content">
            <h2>Bem-vindo(a)!</h2>
            <p class="about-description">Essas são as suas atuais estatísticas de notificações:</p>
            <div class="welcome-panel-column-container">
                <div class="welcome-panel-column">
                    <h3>Usuários</h3>
                    <ul>
                        <li>Cadastrados: <?php echo $info->players; ?></li>
                        <li>Ativos: <?php echo $info->messageable_players; ?></li>
                    </ul>
                </div>
                <div class="welcome-panel-column">
                    <h3>Mensagens</h3>
                    <ul>
                        <li>Enviadas: <?php echo $info2->total_count; ?></li>
                        <!--<li><a href="#">Envie uma Agora</a></li>-->
                    </ul>
                </div>
                <div class="welcome-panel-column welcome-panel-last">
                    <h3><!--Mais ações--></h3>
                    <ul>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="dashboard-widgets-wrap">
        <div class="metabox-holder" id="dashboard-widgets">
            <div id="postbox-container-2" class="postbox-container">
                <div id="side-sortables" class="meta-box-sortables ui-sortable">
                    <div id="dashboard_quick_press" class="postbox ">
                        <h2 class="hndle ui-sortable-handle"><span>Enviar Notificação para Todos</span></h2>
                        <div class="inside">
                            <form name="post" action="" method="post" id="quick-press" class="initial-form">
                                <div class="input-text-wrap" id="title-wrap">
                                    <input type="text" id="push_title" class="regular-text" name="push_title" placeholder="Título" autocomplete="off" required>
                                </div>

                                <div class="textarea-wrap" id="description-wrap">
                                    <textarea rows="3" cols="15" autocomplete="off" placeholder="Mensagem de até 130 caracteres" name="push_msg" maxlength="130" required></textarea>
                                </div>
                                <?php if($reqMsg != null){ ?>
                                    <div class="input-text-wrap" id="title-wrap">
                                        Push Enviado com Sucesso!
                                    </div>
                                <?php } ?>
                                <p class="submit">
                                    <input type="submit" name="save" id="save-post" class="button button-primary" value="Enviar">
                                    <br class="clear">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="postbox-container-1" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div id="dashboard_right_now" class="postbox ">
                        <h2 class="hndle ui-sortable-handle"><span>Sobre o Plugin</span></h2>
                        <div class="inside">
                            <div class="main">
                                <ul>
                                    <li><a href="https://github.com/weslleycsil/NotificationPush_Onesignal" target="_blank">Repositório do Plugin</a></li>
                                    <li>Versão: <?php echo VERSION; ?></li>
                                </ul>
                                <p id="wp-version-message">
                                    <span id="wp-version">Feito por Weslley Silva - <a href="https://twcreativs.com.br" target="_blank">TW Creativs</a>.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
