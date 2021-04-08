<?php
session_start();
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
} else {
    if ($_SESSION['nivel'] == 0) {
        include '../templates/template_admin.php';
    } elseif ($_SESSION['nivel'] == 1) {
        include '../templates/template_usuario.php';
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

