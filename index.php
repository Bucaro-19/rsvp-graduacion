<?php
// --- VALORES DE PRUEBA (MOCK) ---
$total_recaudado = 1450.00; 
$meta = 3500; 
$porcentaje = ($total_recaudado / $meta) * 100;
$ancho_barra = $porcentaje > 100 ? 100 : $porcentaje;

// --- SIMULACIÓN DE TU BASE DE DATOS DE INVITADOS ---
// En producción, esto saldría de un SELECT a tu tabla MySQL usando el token
$invitados_db = [
    'token-aaron' => 'Aaron Estuardo Arriaga Porras',
    'token-maria' => 'María Sobeyda Rosito Batres',
    'token-lena'  => 'Lena'
];

// --- LECTURA DEL ENLACE MÁGICO ---
$token_url = isset($_GET['invitado']) ? $_GET['invitado'] : '';
$nombre_invitado = '';
$acceso_valido = false;

if (array_key_exists($token_url, $invitados_db)) {
    $nombre_invitado = $invitados_db[$token_url];
    $acceso_valido = true;
}

// Simular la recepción del formulario
// Simular la recepción del formulario
$mensaje = "";
// Agregamos isset() para verificar que el campo oculto sí venga en la petición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_confirmado'])) {
    $nombre_post = htmlspecialchars($_POST['nombre_confirmado']);
    $mensaje = "¡Gracias por confirmar, $nombre_post! Nos vemos en la celebración.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduación de Jose</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

    <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center text-white">
            <h1 class="text-3xl font-bold mb-2">¡Me gradúo de Ingeniero! 🎓</h1>
            <p class="text-blue-100">Acompáñame a celebrar este gran logro.</p>
        </div>

        <div class="p-8">
            <div class="bg-slate-100 rounded-xl p-6 mb-8 border border-slate-200">
                <h2 class="text-xl font-semibold mb-2 text-center">Operación: Capuchinera ☕</h2>
                <div class="w-full bg-gray-300 rounded-full h-6 mb-2 overflow-hidden shadow-inner">
                    <div class="bg-green-500 h-6 rounded-full transition-all duration-1000 ease-out" style="width: <?php echo $ancho_barra; ?>%;"></div>
                </div>
                <div class="flex justify-between text-sm font-bold text-slate-700">
                    <span>Q<?php echo number_format($total_recaudado, 2); ?> recaudados</span>
                    <span>Meta: Q<?php echo number_format($meta, 2); ?></span>
                </div>
            </div>

            <?php if($mensaje): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-center font-medium">
                    <?php echo $mensaje; ?>
                </div>
            <?php elseif($acceso_valido): ?>
                
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-medium text-slate-800">¡Hola, <?php echo $nombre_invitado; ?>! 👋</h3>
                    <p class="text-slate-500">Por favor confirma tu asistencia abajo.</p>
                </div>

               <form method="POST" action="?invitado=<?php echo htmlspecialchars($token_url); ?>" class="space-y-5">
                    <input type="hidden" name="nombre_confirmado" value="<?php echo $nombre_invitado; ?>">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">¿Asistirás a la celebración?</label>
                        <select name="asiste" id="asiste-select" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="">Selecciona una opción...</option>
                            <option value="si">¡Sí, ahí estaré!</option>
                            <option value="no">Lamentablemente no podré</option>
                        </select>
                    </div>

                    <div id="seccion-aporte" class="border-t border-slate-200 pt-5 transition-all duration-300">
                        <label class="block text-sm font-medium text-slate-700 mb-1">¿Hiciste una transferencia para la capuchinera? (Opcional)</label>
                        <p class="text-xs text-slate-500 mb-3">Puedes depositar a la cuenta <strong>Monetaria BI #123456789</strong> o por Fri.</p>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500">Q</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="aporte" placeholder="0.00" class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                        Confirmar Asistencia
                    </button>
                </form>

            <?php else: ?>
                
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="text-lg font-medium text-slate-900">Acceso Restringido</h3>
                    <p class="text-slate-500 mt-2">Por favor, utiliza el enlace personalizado que te envié por WhatsApp para confirmar tu asistencia.</p>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <script>
        const selectAsiste = document.getElementById('asiste-select');
        const seccionAporte = document.getElementById('seccion-aporte');

        if(selectAsiste) {
            selectAsiste.addEventListener('change', function() {
                if (this.value === 'no') {
                    seccionAporte.style.display = 'none';
                } else {
                    seccionAporte.style.display = 'block';
                }
            });
        }
    </script>
</body>
</html>