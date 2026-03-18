<?php
require_once 'config.php';

// 1. Obtener Token de la URL
$token_url = isset($_GET['invitado']) ? $_GET['invitado'] : '';
$invitado = null;

if (!empty($token_url)) {
    $stmt = $conn->prepare("SELECT id, nombre, asiste FROM invitados WHERE token = ?");
    $stmt->bind_param("s", $token_url);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $invitado = $resultado->fetch_assoc();
}

// 2. Procesar Respuesta del Formulario
$mensaje_exito = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && $invitado) {
    $asiste = ($_POST['asiste'] == 'si') ? 1 : 0;
    $aporte = !empty($_POST['aporte']) ? floatval($_POST['aporte']) : 0.00;
    
    $update = $conn->prepare("UPDATE invitados SET asiste = ?, aporte = ?, fecha_respuesta = NOW() WHERE id = ?");
    $update->bind_param("idi", $asiste, $aporte, $invitado['id']);
    
    if ($update->execute()) {
        $mensaje_exito = true;
    }
}

// 3. Cálculo de la Barra de Progreso
$meta = 3500;
$res_suma = $conn->query("SELECT SUM(aporte) as total FROM invitados");
$total_recaudado = $res_suma->fetch_assoc()['total'] ?? 0;
$porcentaje = ($total_recaudado / $meta) * 100;
$ancho_barra = ($porcentaje > 100) ? 100 : $porcentaje;
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
            <p class="text-blue-100">Ing. Jose Aurelio Porras Bucaro</p>
        </div>

        <div class="p-8">
            <div class="bg-slate-100 rounded-xl p-6 mb-8 border border-slate-200">
                <h2 class="text-xl font-semibold mb-2 text-center">Operación: Capuchinera ☕</h2>
                <div class="w-full bg-gray-300 rounded-full h-6 mb-2 overflow-hidden shadow-inner">
                    <div class="bg-green-500 h-6 rounded-full transition-all duration-1000 ease-out" style="width: <?php echo $ancho_barra; ?>%;"></div>
                </div>
                <div class="flex justify-between text-sm font-bold text-slate-700">
                    <span>Q<?php echo number_format($total_recaudado, 2); ?></span>
                    <span>Meta: Q<?php echo number_format($meta, 2); ?></span>
                </div>
            </div>

            <?php if ($mensaje_exito): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center font-medium">
                    ¡Gracias por confirmar! Nos vemos pronto.
                </div>
            <?php elseif ($invitado): 
                // AQUÍ ESTÁ LA CORRECCIÓN: Extraemos el primer nombre
                $partes_nombre = explode(' ', trim($invitado['nombre']));
                $primer_nombre = $partes_nombre[0];
            ?>
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-medium">¡Hola, <?php echo htmlspecialchars($primer_nombre); ?>! 👋</h3>
                </div>

                <form method="POST" action="?invitado=<?php echo htmlspecialchars($token_url); ?>" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1">¿Asistirás a la celebración?</label>
                        <select name="asiste" id="asiste-select" required class="w-full px-4 py-2 border rounded-lg outline-none">
                            <option value="">Selecciona...</option>
                            <option value="si">¡Sí, ahí estaré!</option>
                            <option value="no">No podré asistir</option>
                        </select>
                    </div>

                    <div id="seccion-aporte" class="border-t pt-5">
                        <label class="block text-sm font-medium mb-1">Aporte para la capuchinera (Opcional)</label>
                        <p class="text-xs text-slate-500 mb-3">Transferencia a BI Monetaria: <strong>123456789</strong></p>
                        <input type="number" step="0.01" name="aporte" placeholder="Q 0.00" class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition">
                        Confirmar Asistencia
                    </button>
                </form>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-slate-500 italic">Por favor, ingresa mediante el link que te envié por WhatsApp.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const select = document.getElementById('asiste-select');
        const aporte = document.getElementById('seccion-aporte');
        if(select) {
            select.addEventListener('change', () => {
                aporte.style.display = (select.value === 'no') ? 'none' : 'block';
            });
        }
    </script>
</body>
</html>