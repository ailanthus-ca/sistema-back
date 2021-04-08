<div class="modal fade bs-example-modal-lg" id="cargarCotizacionEspera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cotizaciones en Espera</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="bce" placeholder="Buscar cotizaciones" onkeyup="cargar_cotizaciones_espera(1)">
                        </div>
                        <button type="button" class="btn btn-default" onclick="cargar_cotizaciones_espera(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
                    </div>
                </form>
                <div id="cargarEspera" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                <div class="datosEspera" ></div><!-- Datos ajax Final -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
