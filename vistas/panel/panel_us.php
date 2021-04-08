<?php include '../templates/template.php' ?>

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Panel de control <small>Usuario</small></a>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.row -->

                <div class="row col-md-6">

                    <div class="col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                            <a style="text-decoration: none; color: white;" href="ver_productos">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-desktop fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div><h3>Inventario</h3></div>
                                    </div>
                                </div>
                            </a>    
                            </div>
                                <div class="panel-footer">
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <a style="text-decoration: none; color: white;" href="ver_cotizaciones">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-usd fa-4x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><h3>Cotizaciones</h3></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel-footer">
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <a style="text-decoration: none; color: white;" href="ver_proveedores">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-truck fa-4x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><h3>Proveedores</h3></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel-footer">
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a style="text-decoration: none; color: white;" href="ver_clientes">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-fw fa-check-square-o fa-4x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><h3>Clientes</h3></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel-footer">
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </div>
                <div class="row col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <label style="padding-left: 150px;">Cotizaciones pendientes</label>
                        </div>
                        <div id="table_div"></div>
                    </div>
                    <div id="bar" style="width: 500px; height: 200px;"></div>
                </div>
                <br><br>
                <div class="col-md-6">
                    <h2>Ventas del mes</h2>
                </div>
                <br><br>
                <div class="col-md-10"><canvas id="grafico"></canvas></div>
            </div>
                </div>
        <!-- /#page-wrapper -->

<?php include '../templates/template_footer.php' ?>


            <!--Charts Google-->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript" src="./js/dashboard.js"></script>
            <script type="text/javascript" src="./js/chart/Chart.min.js"></script>
            <script type="text/javascript" src="./js/graficar_ventas_dia.js"></script>