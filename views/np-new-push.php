<?php 
    $req = null;
    if(!$this->configComplet())
    {
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Enviar Push Notificação</h1>
        <hr class="wp-header-end">
        <h3>Finalize a Configuração do Plugin para poder Continuar</h3>
    </div>
<?php } else {

        if(isset($_POST['push_title'])) // Se existir o array post, pq ele não retorna undefined index.
        {

            $push = new NP_Push($_POST['push_title'],$_POST['push_msg'],$_POST['push_user'],$_POST['push_date']);
            //$req = $push->sendPush();
            $push->print();
            if(isset($req->errors)){
                $req = null;
            }

        }

        $users = get_users( array( 'fields' => array( 'display_name', 'ID' ),'orderby' => 'display_name' ) );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Enviar Push Notificação</h1>
    <hr class="wp-header-end">
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <?php if($req != null){ ?>
                    <tr class="user-user-login-wrap">
                        <th>
                            <h3>Notificação Enviada</h3>
                        </th>
                    </tr>
                <?php } ?>

                <tr class="user-user-login-wrap">
                    <th><label for="push_title">Título da Notificação:</label></th>
                    <td><input type="text" id="push_title" class="regular-text" name="push_title" required></td>
                </tr>

                <tr class="user-display-name-wrap">
                    <th><label for="push_user">Selecione o Usuário: </label></th>
                    <td>
                        <select name="push_user" required id="display_name">
                            <option value="" selected>Selecione um Usuário</option>
                            <?php foreach ( $users as $user ) { echo'<option value="'.esc_html( $user->ID ).'">'. esc_html( $user->display_name ) .'</option>'; } ?>
                        </select>
                    </td>
                </tr>
                <tr class="user-user-login-wrap">
                    <th><label for="push_date">Data do Envio:</label></th>
                    <td><input id="datetime" type="datetime-local" name="push_date"></td>
                </tr>
                <tr class="user-description-wrap">
                    <th><label for="push_msg">Mensagem:</label></th>
                    <td><textarea rows="4" cols="50" placeholder="Mensagem de até 130 caracteres" name="push_msg" maxlength="130" required></textarea>
                    <p class="description">Sua Mensagem não deverá ultrapassar de até 130 caracteres para que todos possam ter uma boa visualização.</p></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button('Enviar'); ?>
        </p>
    </form>
</div>
<?php            

    }
?>
