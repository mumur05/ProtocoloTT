# PlataformaTT — ESCOM IPN

TT 2026-B077. Plataforma para digitalizar los procesos de Protocolo, TT1 y TT2:
expediente auditable, asignación semántica de sinodales y calendarización.

## Arquitectura

| Capa | Tecnología | Dónde vive |
|---|---|---|
| Vistas | React 19 + Vite (CSS Modules) | `frontend/src/` |
| Backend | PHP 8.2 + MySQL (XAMPP) | archivos `.php` en la raíz |
| Motor de IA | FastAPI + sentence-transformers | `api_asignacion.py` |

Las vistas son React, pero **no es una SPA**: cada página PHP valida la sesión y
luego monta un componente React. Los datos de sesión viajan al front en una
etiqueta `<script type="application/json" id="php-data">`.

Por eso los `.html` de la raíz (`inicio.html`, `iniciarSesion.html`,
`registro.html`) y la carpeta `assets/` **son código generado**: los produce
`npm run build`. Nunca los edites a mano, se sobrescriben.

## Puesta en marcha

### 1. Base de datos

Inicia MySQL desde el panel de XAMPP y crea el esquema:

```
C:\xampp\mysql\bin\mysql.exe -u root -P 3306 -h 127.0.0.1 < bd_registro.sql
```

Revisa que el puerto en `conexion.php` coincida con el de tu MySQL (3306 por defecto).

### 2. Servidor web

Con Apache de XAMPP, enlazando el proyecto a `htdocs`, o con el servidor de PHP:

```
C:\xampp\php\php.exe -S localhost:8080 -t .
```

Abre http://localhost:8080/inicio.html

### 3. Front-end (solo si vas a modificar vistas)

```
cd frontend
npm install
npm run build     # o: npm run watch  (recompila al guardar)
```

### 4. Motor de análisis (opcional)

Solo hace falta para la pantalla de análisis de protocolo.

```
pip install fastapi uvicorn sentence-transformers pypdf python-multipart
uvicorn api_asignacion:app --port 8000
```

## Cómo trabajar en las vistas

Cada vista es un componente en `frontend/src/views/`. El archivo
`frontend/src/main.jsx` mapea el atributo `data-view` del HTML al componente
que le toca.

Para agregar una pantalla nueva:

1. Crea el componente en `frontend/src/views/`.
2. Regístralo en el objeto `VIEWS` de `main.jsx`.
3. Crea el `.php` correspondiente con su control de sesión, copiando el patrón
   de `subir_documentos.php`.
4. Corre `npm run build`.

## Cuentas

El rol se decide por el dominio del correo institucional:
`@alumno.ipn.mx` entra al panel de alumno, `@ipn.mx` al de docente.

El envío de correos está desactivado (`registrar.php`), así que el token de
verificación se consulta en la base de datos:

```
SELECT usuario, token_verificacion FROM bd_registro.usuarios;
```

## Pendientes conocidos

- `registrar.php` usa `$existente` sin definirla: registrar un correo repetido
  lanza un error crudo de la base en vez del mensaje de "ya registrado".
- `login.php` redirige a `validar_token.php`, archivo que no existe; el correcto
  es `validarToken.php`. Un usuario sin verificar recibe un 404 al entrar.
- Las 5 vistas secundarias (subir documentos, estado de expediente, proyectos
  asesorados, evaluar trabajos, firmas) son maquetas sin lógica conectada.
- `compararToken.php` quedó huérfano, lo reemplazó `verificar_token.php`.
