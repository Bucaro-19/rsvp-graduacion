# Despliegue en BanaHosting

Objetivo:

- `https://ingporras.com/` muestra el portafolio.
- `https://ingporras.com/graduacion/` mantiene viva la invitacion RSVP.
- `https://ingporras.com/graduacion/admin.php` mantiene el dashboard.

## Despliegue automatico con GitHub Actions

Este repo ya tiene un workflow en `.github/workflows/main.yml`.

Cuando hagas push a `main`, GitHub Actions:

1. Construye el portafolio desde `portfolio/`.
2. Sube `portfolio/dist/` a la raiz del FTP.
3. Sube `graduacion/` a `/graduacion/`.

Eso significa que normalmente no necesitas subir archivos a mano.

## Preparar el portafolio localmente

Desde tu maquina:

```bash
cd portfolio
npm install
npm run build:hosting
```

Eso genera `portfolio/dist/` con el portafolio listo para revisar o subir manualmente si algun dia lo necesitas.

## Subir a BanaHosting

En cPanel > File Manager:

1. Entra a `public_html`.
2. Haz backup o renombra los archivos actuales si quieres conservar una copia.
3. Sube todo el contenido de `portfolio/dist/` directamente dentro de `public_html`.
4. Crea o sube la carpeta `graduacion` dentro de `public_html`.
5. Dentro de `public_html/graduacion`, sube:
   - `graduacion/index.php`
   - `graduacion/admin.php`
   - `graduacion/capuchinera.webp`
   - `graduacion/zigi-qr.png`
6. Deja `config.php` en `public_html/config.php`.

Importante: no metas `config.php` dentro del commit si contiene credenciales.

## Probar

Abre:

- `https://ingporras.com/`
- `https://ingporras.com/graduacion/?invitado=TOKEN_DE_PRUEBA`
- `https://ingporras.com/graduacion/admin.php`

Si refrescar una ruta del portafolio como `/project/...` da 404, verifica que `public_html/.htaccess` exista. El comando `npm run build:hosting` ya lo copia a `portfolio/dist/.htaccess`.
