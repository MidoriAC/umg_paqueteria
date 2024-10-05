<?php
function kvfj($json, $key){
    if($json == null):
        return null;
    else:
        $json = $json;
        $json = json_decode($json, true);
        if( array_key_exists($key, $json)):
            return $json[$key];
        else:
            return null;
        endif;
    endif;
}
function getRoleUserArray($mode, $id){
    $roles =[
        '0' => 'Administrador',
        '1' => 'Personal',
        '2' => 'Usuario Visitante'
    ];
    if(!is_null($mode)):
        return $roles;
    else:      
        return $roles[$id];
    endif;
}
function getUserStatusArray($mode, $id){
    $status =[
        '0' => 'En Proceso',
        '1' => 'Activo',
        '100' => 'Bloqueado'
    ];
    if(!is_null($mode)):
        return $status;
    else:      
        return $status[$id];
    endif;
}
function user_permissions(){
    $p = [
       'dashboard' => [
         'color' => '#00FF8F',
         'icon' => '<i class="fas fa-archive"></i>',
         'title' => 'Modulo de Dashboards',
         'keys' =>[
             'dashboard' => 'Puede ver el dashboard',
             'auditoria' => 'Puede ver las acciones del sistema',
            ]
         ],
        'user_list' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-user"></i>',
            'title' => 'Modulo de Usuario',
            'keys' =>[
                'user_new' => 'Puede agregar usuarios',
                'user_list' => 'Puede ver el listado de usuarios',
                'user_edit' => 'Puede editar a los usuarios',
                'user_banned' => 'Puede banear a los usuarios',
                'user_account' => 'Puede editar sus propios datos',
                'user_permission' => 'Puede asignar permisos a los usuarios',
            ] 
        ],
        'vehiculos' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de vehiculos',
            'keys' =>[
                'vehiculos' => 'Puede ver el listado de vehiculos',
                'add_vehiculos' => 'Puede Agregar vehiculos',
                'edit_vehiculos' => 'Puede Editar vehiculos',
            ] 
        ],
        'sucursales' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de sucursales',
            'keys' =>[
                'sucursales' => 'Puede ver el listado de sucursales',
                'add_sucursales' => 'Puede Agregar sucursales',
                'edit_sucursales' => 'Puede Editar sucursales',
            ] 
        ], 
        'pasaje' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de pasaje',
            'keys' =>[
                'pasaje' => 'Puede ver el listado de pasajes',
            ] 
        ],
        'envios' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de envios',
            'keys' =>[
                'envios' => 'Puede ver el listado de envios',
                'add_envios' => 'Puede Agregar envios',
                'edit_envios' => 'Puede Editar envios',
                'add_envios_estado' => 'Puede cambiar el estado de los envios',
            ] 
        ],
        'recepcion' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de recepcion',
            'keys' =>[
                'recepcion' => 'Puede ver el listado de recepcion',
                'recepcion_estado' => 'Puede cambiar el estado de recepcion',
            ] 
        ],
        'anuncios' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de anuncios',
            'keys' =>[
                'anuncios' => 'Puede ver el listado de anuncios',
                'add_anuncios' => 'Puede Agregar anuncios',
                'edit_anuncios' => 'Puede Editar anuncios',
                'delete_anuncios' => 'Puede Eliminar anuncios',
            ] 
        ],
        'ventas' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de Ventas',
            'keys' =>[
                'ventas' => 'Puede ver el listado de ventas',
            ] 
        ],
        'reclamos' => [
            'color' => '#00FF8F',
            'icon' => '<i class="fas fa-house-user"></i>',
            'title' => 'Modulo de reclamos',
            'keys' =>[
                'reclamos' => 'Puede ver el listado de reclamos',
            ] 
        ]
    ];
    return $p;
}
?>