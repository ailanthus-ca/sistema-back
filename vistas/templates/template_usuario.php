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

    <body onclick="activo()"  onchange="activo()" style="background: #fff;">

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
                    <a class="navbar-brand" href="panel_us">Ailanthus</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php printf($_SESSION['usuario']) ?><b class="caret"></b></a>
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
                            <a href="panel_us"><i class="fa fa-fw fa-edit"></i> Panel de control</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#compras"><i class="fa fa-fw fa fa-shopping-cart"></i> Compras <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="compras" class="collapse">
                                <li>
                                    <a href="nueva_orden">Generar orden de compra</a>
                                </li>
                                <li>
                                    <a href="ver_ordenes">Administrar ordenes de compra</a>
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
                            </ul>
                        </li>                                                             
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
    </body>
</html>         