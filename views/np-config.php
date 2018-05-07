<div class="wrap">
    <h1 class="wp-heading-inline">Configurações do Plugin NP-Onesignal</h1>
    <hr class="wp-header-end">
    <form action="options.php" method="post">
    <?php
      settings_fields('np-settings-group');
      do_settings_sections('np-settings-group');
    ?>

    <table class="form-table">
        <tbody>
            <tr class="user-user-login-wrap">
                <th><label for="app_key">Chave do App</label></th>
                <td><input type="text" id="np_app_key" class="regular-text" name="np_app_key" value="<?= esc_attr( get_option( 'np_app_key' ) ); ?>"></td>
            </tr>

            <tr class="user-user-login-wrap">
                <th><label for="app_id">Identificador do App</label></th>
                <td><input type="text" id="np_app_id" class="regular-text" name="np_app_id" value="<?= esc_attr( get_option( 'np_app_id' ) ); ?>"></td>
            </tr>
            <tr class="user-user-login-wrap">
                <th><label for="user_key">Chave do Usuario</label></th>
                <td><input type="text" id="np_user_key" class="regular-text" name="np_user_key" value="<?= esc_attr( get_option( 'np_user_key' ) ); ?>"></td>
            </tr>
        </tbody>
    </table>
    <p class="submit">
        <?php submit_button(); ?>
    </p>
  </form>
</div>