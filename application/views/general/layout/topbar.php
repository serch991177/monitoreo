<?php
$id_usuario = $this->session->sistema->id_usuario;

$menus = $this->main->getListSelect('menu', 'accion.*, menu.id_menu', ['preferencia' => 'ASC'], ['id_usuario' => $id_usuario, 'id_estado' => 1, 'es_menu' => 'SI'], null, null, ['accion' => 'id_accion']);
?>

<div data-sticky-container>
  <div data-sticky data-options="marginTop:0;">
    <div class="title-bar gradiente" data-responsive-toggle="example-menu" data-hide-for="medium">
      <button class="menu-icon" type="button" data-toggle="example-menu"></button>
      <div class="title-bar-title palette-White text">SISTEMA DE MONITOREO</div>
    </div>

    <div class="top-bar gradiente palette-White text" id="example-menu">
      <div id="logo">
        <span class="MuiIconButton-label"><img src="<?= base_url('public/images/cocha-large-white.png') ?>" alt="Logo GAMC" style="width: 8cm;"></span>
      </div>
      <ul class="dropdown menu align-medium transparente" data-responsive-menu="accordion medium-dropdown">
        <li id="limenu" class="menu-text transparente">Menú</li>
        <?php foreach ($menus as $menu) : ?>
          <li>
            <?php $ruta = $menu->ruta_amigable; ?>
            <?php if ($menu->ruta_amigable == '') : ?>
              <a class="palette-White text"><i class="<?= $menu->icon ?>"></i><span><?= $menu->nombre_accion ?></span></a>
            <?php else : ?>
              <a class="palette-White text" href="<?= site_url($ruta) ?>"><i class="<?= $menu->icon ?>"></i><span><?= $menu->nombre_accion ?></span></a>
            <?php endif; ?>
            <?php $submenus = $this->main->getListSelect('menu', 'accion.*, menu.id_menu', ['preferencia' => 'ASC'], ['id_usuario' => $id_usuario, 'id_estado' => 1, 'es_submenu' => 'SI', 'id_padre' => $menu->id_accion], null, null, ['accion' => 'id_accion']); ?>

            <?php if ($submenus) : ?>
              <ul class="menu">
                <?php foreach ($submenus as $submenu) : ?>
                  <li>
                    <a class="palette-White text" href="<?= site_url($submenu->ruta_amigable) ?>">
                      <i class="<?= $submenu->icon ?>"></i><span><?= $submenu->nombre_accion ?></span>
                    </a>

                    <?php $sub_submenus = $this->main->getListSelect('menu', 'accion.*, menu.id_menu', ['id_menu' => 'ASC'], ['id_usuario' => $id_usuario, 'id_estado' => 1, 'es_sub_submenu' => 'SI', 'id_padre' => $submenu->id_accion], null, null, ['accion' => 'id_accion']); ?>

                    <?php if ($sub_submenus) : ?>
                      <ul class="menu">
                        <?php foreach ($sub_submenus as $sub_submenu) : ?>
                          <li>
                            <a class="palette-White text" href="<?= site_url($sub_submenu->ruta_amigable) ?>">
                              <i class="<?= $sub_submenu->icon ?>"></i><span><?= $sub_submenu->nombre_accion ?></span>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<br>
