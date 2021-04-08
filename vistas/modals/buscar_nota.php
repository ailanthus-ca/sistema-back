<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="cargarNota" tabindex="-1" role="dialog" aria-labelledby="cargarNotaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cargarNotaLabel">Cargar Nota de Entrega</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="bn" placeholder="Buscar Nota de Entrega" onkeyup="cargar_nota(1)">
                        </div>
                        <button type="button" class="btn btn-default" onclick="cargar_nota(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
                    </div>
                </form>
                <div id="cargarN" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                <div class=".otro" id="notas" ></div><!-- Datos ajax Final -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
