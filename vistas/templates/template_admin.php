<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Ailanthus</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="bootstrap/css/sb-admin.css" rel="stylesheet">
        <!-- Morris Charts CSS -->
        <link href="bootstrap/css/plugins/morris.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    </head>
    <body onclick="activo()" onchange="activo()" style="background: #fff;">
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="panel_ad">Ailanthus</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a id="usuario" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php printf($_SESSION['usuario']) ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="perfil"><i class="fa fa-fw fa-user"></i> Perfil</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="config/salir.php"><i class="fa fa-fw fa-power-off"></i> Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="">
                            <a href="panel_ad"><i class="fa fa-fw fa-edit"></i> Panel de control</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#compras"><i class="fa fa-fw fa fa-shopping-cart"></i> Compras <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="compras" class="collapse">
                                <li>
                                    <a href="nueva_orden">Generar orden de compra</a>
                                </li>
                                <li>
                                    <a href="nueva_compra">Nueva compra</a>
                                </li>
                                <li>
                                    <a href="ver_ordenes">Administrar ordenes de compra</a>
                                </li>
                                <li>
                                    <a href="ver_compras">Administrar compras</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#cotizacion"><i class="fa fa-fw fa fa-calculator"></i> Cotización <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="cotizacion" class="collapse">
                                <li>
                                    <a href="nueva_cotizacion">Nueva cotizacion</a>
                                </li>
                                <li>
                                    <a href="ver_cotizaciones">Administrar cotizaciones</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#notas"><i class="fa fa-fw fa fa-send"></i> Notas de Entrega <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="notas" class="collapse">
                                <li>
                                    <a href="nueva_nota">Nueva Nota de Entrega</a>
                                </li>
                                <li>
                                    <a href="ver_notas">Administrar Notas de Entrega</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#facturacion"><i class="fa fa-fw fa fa-usd"></i> Facturación <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="facturacion" class="collapse">
                                <li>
                                    <a href="nueva_factura">Nueva factura</a>
                                </li>
                                <li>
                                    <a href="ver_facturas">Administrar facturas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#proveedores"><i class="fa fa-fw fa fa-truck"></i> Proveedores <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="proveedores" class="collapse">
                                <li>
                                    <a href="ver_proveedores">Ver proveedores</a>
                                </li>
                                <li>
                                    <a href="nuevo_proveedor">Nuevo proveedor</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#clientes"><i class="fa fa-fw fa fa-user"></i> Clientes <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="clientes" class="collapse">
                                <li>
                                    <a href="ver_clientes">Ver clientes</a>
                                </li>
                                <li>
                                    <a href="nuevo_cliente">Nuevo cliente</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#inventario"><i class="fa fa-fw fa fa-laptop"></i> Inventario <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="inventario" class="collapse">
                                <li>
                                    <a href="ver_productos">Consulta de inventario</a>
                                </li>
                                <li>
                                    <a href="nuevo_producto">Registro de productos</a>
                                </li>
                                <li>
                                    <a href="ajuste_inventario">Ajuste de inventario</a>
                                </li>
                                <li>
                                    <a href="ajuste_utilidad">Ajuste de utilidad</a>
                                </li>
                                <li>
                                    <a href="ajuste_precio">Ajuste de Precio</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#reportes"><i class="fa fa-fw fa-bar-chart"></i> Reportes <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="reportes" class="collapse">
                                <li>
                                    <a href="reporte_compras">Reporte de compras</a>
                                </li>
                                <li>
                                    <a href="reporte_ventas">Reporte de ventas</a>
                                </li>
                                <li>
                                    <a href="reporte_vendedor">Reporte de vendedores</a>
                                </li>
                                <li>
                                    <a href="reporte_ajustes">Reporte de ajustes de inventario</a>
                                </li>
                                <li>
                                    <a href="reporte_inventario">Reporte de inventario</a>
                                </li>
                                <li>
                                    <a href="rubros">Reporte de rubros por mes</a>
                                </li>
                                <li>
                                    <a href="seguimiento">Seguimiento de compras</a>
                                </li>
                                <li>
                                    <a href="historico">historico de productos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa fa-users"></i> Usuarios <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="demo" class="collapse">
                                <li>
                                    <a href="ver_usuarios">Ver usuarios</a>
                                </li>
                                <li>
                                    <a href="nuevo_usuario">Nuevo Usuario</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#parametros"><i class="fa fa-fw fa fa-sliders"></i> Parametros <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="parametros" class="collapse">
                                <li>
                                    <a href="tipo_producto">Tipo de producto</a>
                                </li>
                                <li>
                                    <a href="unidades">Unidades</a>
                                </li>
                                <li>
                                    <a href="departamentos">Departamentos</a>
                                </li>
                                <li>
                                    <a href="moneda">Monedas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#configuracion"><i class="fa fa-fw fa fa-wrench"></i> Configuración <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="configuracion" class="collapse">
                                <li>
                                    <a href="conf_ventas">Configuración de ventas</a>
                                </li>
                                <li>
                                    <a href="conf_region">Configuración de región</a>
                                </li>
                                <li>
                                    <a href="conf_factura">Configuración de factura</a>
                                </li>
                                <li>
                                    <a href="conf_empresa">Datos de la empresa</a>
                                </li>
                                <li>
                                    <a href="horarios">Horarios de Trabajo</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>