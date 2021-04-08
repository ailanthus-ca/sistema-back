Tabla = function (conten, head, data, body, NumRow = null) {
    this.tb = conten; //contenedor y nombre de la tabla
    this.head = head; //titulos de la tabla
    this.data = data; //datos de la tabla
    this.body = body; //orden en que se muestran los datos
    this.zise = null; //tama?o de las columnas
    this.tamPagina = NumRow; //el tama?o de la p?gina (filas por p?gina)
    this.numPaginas = Math.ceil((data.length) / this.tamPagina); //??
    this.pagActual = 1;
    this.paginas = [];
    this.criterio = null;
    this.bc = null;
    this.sepcell = [{'cell': null, 'fun': null}];
    this.tbd;
    this.tft;
    this.thead;
    this.nuevo = document.createElement('button');
    this.aling = [null];
    this.custonhead = null;
    this.orden = {col: null, est: null};
    this.tittles = [];
    //carga la tabla sin elementos
    this.cargar = function () {
        var elem, foot;
        this.createHead();
        foot = this.create('tfoot');
        foot.appendChild(this.create('tr'));
        elem = this.create('td');
        elem.align = 'right';
        elem.colSpan = this.body.length;
        foot.childNodes[0].appendChild(elem);
        this.tbd = this.create('tbody');
        this.tft = elem;
        this.tb.appendChild(this.thead);
        this.tb.appendChild(this.tbd);
        this.tb.appendChild(foot);
        this.thead = this.tb.childNodes[0].childNodes[0].childNodes[0].childNodes[0];
        if (this.custonhead !== null)
            this.thead.appendChild(this.custonhead);
        this.paginar();
        this.Mostrar();
    };
    //crear head
    this.createHead = function () {
        var head, titles, tablas = '<tr><td colspan="' + this.body.length + '"><div><strong>Buscar: </strong><input type="search"/></div></td></tr><tr></tr>';
        head = this.create('thead');
        head.innerHTML = tablas;
        titles = head.childNodes[1];
        for (var i = 0; i < this.head.length; i++) {
            var title = this.create('th');
            title.innerHTML = this.head[i];
            title.onkeyup = this;
            title.keytype = i;
            title.onclick = function () {
                this.onkeyup.ordenar(this.keytype);
                for (var i = 0; i < this.onkeyup.head.length; i++) {
                    this.onkeyup.tittles[i].innerHTML = this.onkeyup.head[i];
                }
                if (this.onkeyup.orden.est === 'a') {
                    this.innerHTML = this.onkeyup.head[this.keytype] + '<span class="icon-arrow-down"></span>';
                } else {
                    this.innerHTML = this.onkeyup.head[this.keytype] + '<span class="icon-arrow-up"></span>';
                }
                this.onkeyup.paginar();
                this.onkeyup.Mostrar();
            };
            if (this.zise !== null) {
                title.width = this.zise[i] + '%';
            }
            this.tittles.push(title);
            titles.appendChild(title);
        }
        this.bc = head.childNodes[0].childNodes[0].childNodes[0].childNodes[1];
        this.bc.action = this;
        this.bc.oninput = function () {
            this.action.paginar();
            this.action.Mostrar();
        };
        this.nuevo.innerHTML = 'Nuevo';
        head.childNodes[0].childNodes[0].childNodes[0].appendChild(this.nuevo);
        this.thead = head;

    };
    // array de los tamanos de las columnas
    this.columZise = function (zise) {
        this.zise = zise;
    };
    //array de las alineaciones de las columnas
    this.columAling = function (aling) {
        this.aling = aling;
    };
    //crea las paginas de la tabla
    this.paginar = function () {
        var mostrar = this.buscar();
        this.numPaginas = Math.ceil((mostrar.length) / this.tamPagina); //??
        var ele = 0, cc;
        if (this.tamPagina !== null) {
            if (this.numPaginas > 0) {
                for (var i = 1; i <= this.numPaginas; i++) {
                    var pagina = '';
                    for (var j = 0; j < this.tamPagina; j++) {
                        pagina += '<tr>';
                        if (ele < mostrar.length) {
                            for (var k = 0; k < this.body.length; k++) {
                                cc = true;
                                for (var l = 0; l < this.sepcell.length; l++) {
                                    if (cc) {
                                        pagina += '<td ';
                                        if (this.aling[k] != null) {
                                            pagina += 'align="' + this.aling[k] + '"';
                                        }
                                        if (this.zise != null) {
                                            pagina += 'width="' + this.zise[k] + '%"';
                                        }
                                        if (this.sepcell[l].cell === this.body[k]) {
                                            pagina += '>' + this.sepcell[l].fun(mostrar[ele]) + '</td>';
                                            cc = false;
                                        } else if (this.sepcell[l].cell === null) {
                                            pagina += '>' + mostrar[ele][this.body[k]] + '</td>';
                                            cc = false;
                                        }
                                    }
                                }
                            }
                            ele++;
                        }
                        pagina += '</tr>';
                    }
                    this.paginas[i - 1] = pagina;
                }
            } else {
                pagina = ' <tr><td colspan="' + this.body.length + '">No se encontraro elementos</td></tr>';
                this.paginas[0] = pagina;
                this.numPaginas = 1;
            }
        } else {

        }
    };
    //numero de pagina que se desea mostrar
    this.Mostrar = function (num) {
        num = typeof num !== 'undefined' ? num : 1;
        this.tbd.innerHTML = this.paginas[num - 1];
        this.pagActual = num;
        this.foot();
    };
    //pasa a la siguiente pagina
    this.sig = function () {
        if (this.pagActual < this.numPaginas) {
            this.Mostrar(this.pagActual + 1);
        }
    };
    //pasa a la pagina anterior
    this.ant = function () {
        if (this.pagActual > 1) {
            this.Mostrar(this.pagActual - 1);
        }
    };
    //crea el footer de la tabla
    this.foot = function () {
        this.tft.innerHTML = '';
        this.tft.appendChild(this.btnfoot('ant'));
        this.tft.appendChild(this.btnfoot(1));
        for (var i = 3; i > 0; i--) {
            var num = this.pagActual - i;
            if (1 < num) {
                if (i !== 3) {
                    this.tft.appendChild(this.btnfoot(num));
                } else {
                    this.tft.appendChild(this.btnfoot('...'));
                }
            }
        }
        if ((this.pagActual !== 1) && (this.pagActual !== this.numPaginas)) {
            this.tft.appendChild(this.btnfoot(this.pagActual));
        }
        for (var i = 1; i < 4; i++) {
            var num = this.pagActual + i;
            if (this.numPaginas > num) {
                if (i === 3) {
                    this.tft.appendChild(this.btnfoot('...'));
                } else {
                    this.tft.appendChild(this.btnfoot(num));
                }
            }
        }
        if (this.numPaginas !== 1) {
            this.tft.appendChild(this.btnfoot(this.numPaginas));
        }
        this.tft.appendChild(this.btnfoot('sig'));
    };
    //asigina una funcion para el campo especial
    this.cellcuston = function (cell, fun) {
        this.sepcell.unshift({'cell': cell, 'fun': fun});
    };
    //campos en los que se realizara la busqueda
    this.search = function (datos) {
        this.criterio = datos;
    };
    //crea los botones del footer
    this.btnfoot = function (dato) {
        var btn = document.createElement('button');
        switch (dato) {
            case 'ant':
                btn.action = this;
                btn.onclick = function () {
                    this.action.ant();
                };
                btn.className = 'ant';
                btn.innerHTML = '<<';
                return btn;
            case 'sig':
                btn.action = this;
                btn.onclick = function () {
                    this.action.sig();
                };
                btn.className = 'sig';
                btn.innerHTML = '>>';
                return btn;
            case '...':
                btn.innerHTML = '...';
                return btn;

            default :
                btn.action = this;
                btn.onclick = function () {
                    this.action.Mostrar(dato);
                };
                if (this.pagActual === dato) {
                    btn.style.background = '#009933';
                    btn.style.color = '#cccccc';
                }
                btn.innerHTML = dato;
                return btn;
        }
    };
    //funcion que realiza la busqueda
    this.buscar = function () {
        var bc = this.bc.value.toUpperCase(),
                mostrar = [],
                criterio = this.criterio;
        if (criterio !== null) {
            if (bc !== '') {
                var campos = Object.keys(this.data[0]);
                var cont;
                this.data.forEach((elem1, i) => {
                    cont = true;
                    for (var j = 0; j < campos.length; j++) {
                        for (var k = 0; k < criterio.length; k++) {
                            if (criterio[k] === campos[j]) {
                                if (('' + elem1[campos[j]]).search(bc) !== -1) {
                                    if (cont) {
                                        mostrar.push(elem1);
                                        cont = false;
                                    }
                                }

                            }
                        }
                    }
                });
            } else {
                mostrar = this.data;
            }
        } else {
            if (bc !== '') {
                var campos = Object.keys(this.data[0]);
                var cont;
                this.data.forEach((elem1, i) => {
                    cont = true;
                    for (var j = 0; j < campos.length; j++) {
                        if (('' + elem1[campos[j]]).search(bc) !== -1) {
                            if (cont) {
                                mostrar.push(elem1);
                                cont = false;
                            }
                        }
                    }
                });
            } else {
                mostrar = this.data;
            }
        }
        return mostrar;
    };
    //create element
    this.create = function (tag) {
        return document.createElement(tag);
    };
    //ordenar 
    this.ordenar = function (num, orden = 'd') {
        var col = this.body[num];
        if (this.orden.col !== this.body[num]) {
            this.orden.col = this.body[num];
            this.orden.est = orden;
        } else {
            if (this.orden.est === 'd') {
                this.orden.est = 'a';
            } else {
                this.orden.est = 'd';
            }
        }
        if (this.orden.est === 'a') {
            this.data.sort(function (a, b) {
                if (a[col] > b[col]) {
                    return 1;
                }
                if (a[col] < b[col]) {
                    return -1;
                }
                return 0;
            });
        } else if (this.orden.est === 'd') {
            this.data.sort(function (a, b) {
                if (a[col] < b[col]) {
                    return 1;
                }
                if (a[col] > b[col]) {
                    return -1;
                }
                return 0;
            });
    }
    };

};

