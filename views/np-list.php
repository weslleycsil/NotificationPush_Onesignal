<?php date_default_timezone_set("America/Sao_Paulo"); if(!$this->configComplet()){ ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Lista de Notificações Enviadas</h1>
        <hr class="wp-header-end">
        <h3>Finalize a Configuração do Plugin para poder Continuar</h3>
    </div>
<?php } else { ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Lista de Notificações Enviadas</h1>
        <hr class="wp-header-end">
    <?php 
    $req = new NP_Onesignal();
    $result = $req->listNotifications(20);
    if($result->total_count > 0){
        $lista = $result->notifications;
?>
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <th scope="col" class="">ID</th>
                    <th scope="col" class="">Título</th>
                    <th scope="col" class="">Usuários</th>
                    <th scope="col" class="">Horário</th>
                </tr>
            </thead>
            <tbody id="">
            <?php foreach ( $lista as $notificacao ) { ?>
                <tr>
                    <td class=""><?php echo esc_html( $notificacao->id ); ?></td>
                    <td class=""><?php echo esc_html( $notificacao->headings->en ); ?></td>
                    <td class=""><?php if(isset($notificacao->include_player_ids)){ echo count($notificacao->include_player_ids); } else { echo $notificacao->successful;} ?></td>
                    <td class=""><?php echo date("H:i d/m/Y", $notificacao->send_after ); ?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr></tr>
            </tfoot>

        </table>
    

<?php
    } else {
        echo '<h3>Não Há Registros</h3>';
    }
    ?>
</div>
<?php } ?>