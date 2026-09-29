(() => {
    fetch('versiones_imagenes.php', { cache: 'no-store' })
        .then((respuesta) => {
            if (!respuesta.ok) {
                throw new Error('No se pudieron obtener las versiones de las imágenes.');
            }
            return respuesta.json();
        })
        .then(iniciarFondo)
        .catch((error) => console.error('No se pudo iniciar el fondo rotativo:', error));

    function iniciarFondo({ imagenes, imagenesAnuncios }) {
    const consultaAnunciosLaterales = window.matchMedia('(min-width: 1280px)');
    const publicidadActiva = false;
    const duracionImagen = 6000;
    const duracionFundido = 1800;
    const claveEstado = 'golf_app_fondo_rotativo';

    if (!document.body) {
        return;
    }

    const capaA = document.createElement('div');
    const capaB = document.createElement('div');
    capaA.className = 'fondo-rotativo-capa';
    capaB.className = 'fondo-rotativo-capa';
    capaA.setAttribute('aria-hidden', 'true');
    capaB.setAttribute('aria-hidden', 'true');
    document.body.prepend(capaA, capaB);

    const mostrarAnuncios = publicidadActiva && !document.body.hasAttribute('data-sin-anuncios');
    let contenedorAnuncios;
    if (mostrarAnuncios) {
        contenedorAnuncios = document.createElement('div');
        contenedorAnuncios.className = 'anuncios-publicitarios';
        document.body.insertBefore(contenedorAnuncios, document.body.children[2] || null);
    }

    let indice = 0;
    let ultimoCambio = Date.now();
    try {
        const estadoGuardado = JSON.parse(localStorage.getItem(claveEstado));
        if (Number.isInteger(estadoGuardado?.indice) && Number.isFinite(estadoGuardado?.ultimoCambio)) {
            indice = ((estadoGuardado.indice % imagenes.length) + imagenes.length) % imagenes.length;
            ultimoCambio = estadoGuardado.ultimoCambio;
        }
    } catch {
        // Start at the first image if local storage is unavailable.
    }

    let capaActual = capaA;
    let capaSiguiente = capaB;
    capaActual.style.backgroundImage = `url("${imagenes[indice]}")`;
    capaActual.classList.add('activa');

    const cargasImagenes = new Map();

    function cargarImagen(ruta) {
        if (!cargasImagenes.has(ruta)) {
            const carga = new Promise((resolve) => {
                const imagen = new Image();
                imagen.decoding = 'async';
                imagen.onload = () => resolve(true);
                imagen.onerror = () => resolve(false);
                imagen.src = ruta;

                if (imagen.complete) {
                    resolve(imagen.naturalWidth > 0);
                }
            });
            cargasImagenes.set(ruta, carga);
            carga.then((cargada) => {
                if (!cargada && cargasImagenes.get(ruta) === carga) {
                    cargasImagenes.delete(ruta);
                }
            });
        }

        return cargasImagenes.get(ruta);
    }

    function precargarProximaImagen() {
        cargarImagen(imagenes[(indice + 1) % imagenes.length]);
    }

    function guardarEstado() {
        try {
            localStorage.setItem(claveEstado, JSON.stringify({ indice, ultimoCambio }));
        } catch {
            // The rotation still works if local storage is unavailable.
        }
    }

    function rutaImagenAnuncio(indiceImagen) {
        const formato = consultaAnunciosLaterales.matches ? imagenesAnuncios.verticales : imagenesAnuncios.apaisadas;
        return formato[indiceImagen];
    }

    const anuncios = mostrarAnuncios ? [
        crearAnuncio('izquierdo', indice % imagenesAnuncios.apaisadas.length),
        crearAnuncio('derecho', (indice + 1) % imagenesAnuncios.apaisadas.length)
    ] : [];

    function actualizarFormatoAnuncios() {
        anuncios.forEach((anuncio) => {
            anuncio.actual.style.backgroundImage = `url("${rutaImagenAnuncio(anuncio.indiceActual)}")`;
            anuncio.siguiente.style.backgroundImage = `url("${rutaImagenAnuncio(anuncio.indiceSiguiente)}")`;
        });
    }

    if (mostrarAnuncios) {
        consultaAnunciosLaterales.addEventListener('change', actualizarFormatoAnuncios);
    }

    function crearAnuncio(lado, indiceImagen) {
        const anuncio = document.createElement('aside');
        const imagenA = document.createElement('div');
        const imagenB = document.createElement('div');
        const etiqueta = document.createElement('span');

        anuncio.className = `anuncio-lateral anuncio-lateral-${lado}`;
        anuncio.setAttribute('aria-label', 'Espacio Publicitario');
        anuncio.setAttribute('role', 'complementary');
        imagenA.className = 'anuncio-imagen activa';
        imagenB.className = 'anuncio-imagen';
        imagenA.style.backgroundImage = `url("${rutaImagenAnuncio(indiceImagen)}")`;
        etiqueta.className = 'anuncio-etiqueta';
        etiqueta.textContent = 'Espacio Publicitario';
        anuncio.append(imagenA, imagenB, etiqueta);
        contenedorAnuncios.append(anuncio);

        return {
            imagenA,
            imagenB,
            actual: imagenA,
            siguiente: imagenB,
            indiceActual: indiceImagen,
            indiceSiguiente: indiceImagen
        };
    }

    function programarCambio() {
        window.setTimeout(() => {
            const siguienteIndice = (indice + 1) % imagenes.length;
            cargarImagen(imagenes[siguienteIndice]).then((cargada) => {
                if (!cargada) {
                    ultimoCambio = Date.now();
                    guardarEstado();
                    programarCambio();
                    return;
                }

                indice = siguienteIndice;
                ultimoCambio = Date.now();
                guardarEstado();

                const indiceAnuncio = indice % imagenesAnuncios.apaisadas.length;
                capaSiguiente.style.backgroundImage = `url("${imagenes[indice]}")`;
                requestAnimationFrame(() => capaSiguiente.classList.add('activa'));
                capaActual.classList.remove('activa');

                anuncios.forEach((anuncio, posicion) => {
                    const indiceImagen = (indiceAnuncio + posicion) % imagenesAnuncios.apaisadas.length;
                    anuncio.indiceSiguiente = indiceImagen;
                    anuncio.siguiente.style.backgroundImage = `url("${rutaImagenAnuncio(indiceImagen)}")`;
                    requestAnimationFrame(() => anuncio.siguiente.classList.add('activa'));
                    anuncio.actual.classList.remove('activa');
                });

                window.setTimeout(() => {
                    [capaActual, capaSiguiente] = [capaSiguiente, capaActual];
                    anuncios.forEach((anuncio) => {
                        [anuncio.actual, anuncio.siguiente] = [anuncio.siguiente, anuncio.actual];
                        anuncio.indiceActual = anuncio.indiceSiguiente;
                    });
                }, duracionFundido);

                precargarProximaImagen();
                programarCambio();
            });
        }, Math.max(0, ultimoCambio + duracionImagen - Date.now()));
    }

    cargarImagen(imagenes[indice]).then((cargada) => {
        if (cargada) {
            precargarProximaImagen();
        }
        ultimoCambio = Date.now();
        guardarEstado();
        programarCambio();
    });
    }
})();