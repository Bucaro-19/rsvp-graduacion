<?php
require_once 'config.php';

// --- CONFIGURACIÓN DE ENLACES EXTERNOS ---
$waze_link = "https://www.waze.com/en/live-map/directions/gt/sacatepequez/san-lucas-sacatepequez/zion-food-and-drinks?place=ChIJDxP-JggLiYURqlXH1529H68";
$bi_cobro_link = "https://belappgt.bi.com.gt/qr?type=tm&qrdata=60c215c4876ddaef27f406f01a303d255eb0ce6f579138a0efa38fc90ff211a3";

// --- Obtener Token de la URL ---
$token_url = isset($_GET['invitado']) ? $_GET['invitado'] : '';
$invitado = null;

if (!empty($token_url)) {
    $stmt = $conn->prepare("SELECT id, nombre, asiste FROM invitados WHERE token = ?");
    $stmt->bind_param("s", $token_url);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $invitado = $resultado->fetch_assoc();
}

// --- Procesar Respuesta del Formulario ---
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

// --- CÁLCULO DE LA BARRA DE PROGRESO ---
$meta = 1778; 

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
    <title>Celebración de Graduación de Aurelio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .font-elegant { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Roboto', sans-serif; }
    </style>
</head>
<body class="bg-[#002B5B] min-h-screen p-4 md:p-6 text-slate-900">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-[#C5A059]">
        
        <div class="p-8 text-center bg-white border-b-2 border-slate-100">
            <img src="https://img.icons8.com/fluency/96/graduation-cap.png" alt="birrete" class="mx-auto mb-4 h-20 w-20">
            <p class="text-sm uppercase tracking-widest text-slate-500">Te invitamos a la</p>
            <h1 class="text-6xl font-elegant text-[#C5A059] mt-2 mb-2">Celebración</h1>
            <h2 class="text-3xl font-bold uppercase tracking-tight text-[#002B5B]">De Graduación</h2>
            <p class="text-2xl font-elegant text-[#C5A059] mt-1">de Aurelio :)</p>
        </div>

        <div class="p-8 space-y-8">

            <?php if ($invitado): 
                // --- LÓGICA DE NOMBRES INTELIGENTE ---
                $partes_nombre = explode(' ', trim($invitado['nombre']));
                $palabra1 = mb_strtolower($partes_nombre[0], 'UTF-8');
                $prefijos = ['tia', 'tía', 'tio', 'tío', 'papa', 'papá', 'mama', 'mamá'];
                
                // Si la primera palabra es un prefijo y hay más de una palabra en el nombre
                if (in_array($palabra1, $prefijos) && count($partes_nombre) > 1) {
                    $primer_nombre = $partes_nombre[0] . ' ' . $partes_nombre[1];
                } else {
                    $primer_nombre = $partes_nombre[0];
                }
            ?>
                <div class="text-center">
                    <h3 class="text-2xl font-medium text-[#002B5B]">¡Hola, <?php echo htmlspecialchars($primer_nombre); ?>! 👋</h3>
                    <p class="text-lg text-slate-700 mt-3 leading-relaxed">
                        Me gustaría que me acompañes en este momento tan especial e importante. Es un gusto poder celebrarlo contigo.
                    </p>
                    <div class="bg-amber-50 border border-amber-200 text-amber-900 rounded-xl p-4 mt-6 text-left shadow-sm">
                        <strong>🌮 Almuerzón Pérez:</strong> Habrá un buffet de tacos, así que por favor llega con hambre. ¡Te espero!
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-b border-slate-100 py-8">
                <div class="text-center flex flex-col items-center">
                    <svg class="h-10 w-10 text-[#C5A059] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-sm font-medium text-slate-500 uppercase">Cuándo</p>
                    <p class="text-lg font-bold text-[#002B5B]">Sábado<br>Abril 18</p>
                </div>
                <div class="text-center flex flex-col items-center">
                    <svg class="h-10 w-10 text-[#C5A059] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium text-slate-500 uppercase">Hora</p>
                    <p class="text-lg font-bold text-[#002B5B]">1:00 P.M.</p>
                </div>
                <div class="text-center flex flex-col items-center">
                    <svg class="h-10 w-10 text-[#C5A059] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <p class="text-sm font-medium text-slate-500 uppercase">Dónde</p>
                    <p class="text-lg font-bold text-[#002B5B]">Zion Restaurant,<br>San Lucas Sacatepéquez</p>
                    <a href="<?php echo $waze_link; ?>" target="_blank" class="inline-flex items-center gap-2 mt-3 bg-[#33CCFF] hover:bg-[#2EB8E6] text-white text-sm font-bold py-2 px-4 rounded-full shadow transition">
                        <img src="https://img.icons8.com/color/24/waze.png" alt="waze">
                        Abrir en Waze
                    </a>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 text-red-950 rounded-2xl p-6 space-y-4 shadow-inner">
                <div class="flex gap-4">
                    <svg class="h-6 w-6 text-red-700 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h4 class="font-bold">⚠️ Nota sobre el parqueo</h4>
                        <p class="text-sm mt-1">El lugar no cuenta con mucho parqueo, por lo que te agradezco si puedes llegar en carpooling o pedir <strong>"jalón"</strong>.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <svg class="h-6 w-6 text-red-700 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <div>
                        <h4 class="font-bold text-red-900">🚨 Fecha límite para confirmar</h4>
                        <p class="text-sm mt-1">Tienes a más tardar el <strong>1 de Abril</strong> para confirmar. Si no confirmas, no podré tomarte en cuenta ya que se está pagando plato por persona. Si no puedes asistir, no te preocupes, ¡lo entiendo perfectamente!</p>
                    </div>
                </div>
            </div>

            <?php if ($mensaje_exito): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-5 rounded-xl text-center font-medium shadow-md">
                    ¡Gracias por responder! Tu confirmación se ha guardado con éxito.
                </div>
            <?php elseif ($invitado): ?>
                
                <form method="POST" action="?invitado=<?php echo htmlspecialchars($token_url); ?>" class="space-y-6 bg-slate-50 p-6 rounded-2xl border border-slate-100 shadow-inner">
                    <h3 class="text-xl font-bold text-[#002B5B]">Confirma tu asistencia</h3>
                    
                    <div>
                        <select name="asiste" required class="w-full px-4 py-3 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-[#C5A059] focus:border-[#C5A059] text-lg transition mb-4">
                            <option value="">Selecciona una opción...</option>
                            <option value="si">¡Sí, ahí estaré!</option>
                            <option value="no">Lamentablemente no podré ir</option>
                        </select>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <h4 class="text-lg font-bold text-[#002B5B] mb-2">Regalo de Graduación ☕</h4>
                        <p class="text-sm text-slate-700 mb-4 leading-relaxed bg-blue-50 p-3 rounded-lg border border-blue-100">
                            Mi gran deseo es poder comprarme una <strong>capuchinera</strong>. Si está en tus manos el ayudarme con lo que desees, lo recibo con mucho amor, mas no es obligatorio.
                        </p>
                        
                        <label class="block text-sm font-medium mb-1">Si hiciste un aporte, regístralo aquí (Opcional):</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-600 text-lg">Q</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="aporte" placeholder="0.00" class="w-full pl-10 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#C5A059] focus:border-[#C5A059] text-lg transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#002B5B] hover:bg-[#001D3D] text-white font-bold py-4 rounded-xl shadow-lg transition duration-150 transform hover:-translate-y-0.5 text-lg">
                        Enviar Respuesta
                    </button>
                </form>

            <?php else: ?>
                <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                    <p class="text-slate-500 italic text-lg">Por favor, ingresa mediante el link personalizado que te envié por WhatsApp.</p>
                </div>
            <?php endif; ?>

            <div class="border-t border-slate-100 pt-8 mt-8 space-y-6 bg-slate-50 p-6 rounded-2xl shadow-inner">
                <h3 class="text-xl font-bold text-[#002B5B] text-center">Datos para aportar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button type="button" onclick="document.getElementById('modal-zigi').classList.toggle('hidden')" class="inline-flex items-center justify-center gap-3 bg-[#6C22D6] hover:bg-[#5A1CB2] text-white font-bold py-3 px-6 rounded-xl shadow transition text-center w-full">
                        <img src="https://zigi.app/favicon.ico" alt="zigi" class="h-6 w-6">
                        Ver QR de Zigi
                    </button>
                    
                    <a href="<?php echo $bi_cobro_link; ?>" target="_blank" class="inline-flex items-center justify-center gap-3 bg-[#004791] hover:bg-[#003B78] text-white font-bold py-3 px-6 rounded-xl shadow transition text-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Link de Cobro BI
                    </a>
                </div>

                <div id="modal-zigi" class="hidden mt-4 text-center bg-white p-6 rounded-xl border border-[#6C22D6] shadow-md">
                    <p class="text-base font-bold text-[#6C22D6] mb-1">Escanea este código desde tu app Zigi</p>
                    <p class="text-sm text-slate-600 mb-4 bg-purple-50 p-2 rounded-lg border border-purple-100">
                        💡 <strong>¡Súper dato!</strong> Este código también funciona con <strong>CUIIK</strong> si usas otro banco.
                    </p>
                    <img src="zigi-qr.PNG" alt="Zigi QR" class="mx-auto w-48 h-48 rounded-lg shadow-sm border mb-4">
                    <a href="zigi-qr.PNG" download class="inline-block bg-slate-100 text-[#6C22D6] font-bold py-2 px-4 rounded-lg hover:bg-slate-200 transition">
                        📥 Descargar Código QR
                    </a>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-3">Depósito o Transferencia</h4>
                    <p class="text-slate-700 text-base">Banco Industrial, Cuenta de Ahorro</p>
                    <p class="text-3xl font-bold text-[#002B5B] mt-1 tracking-wider">5729909</p>
                    <p class="text-slate-600 text-sm mt-2 font-medium">A nombre de: Jose Aurelio Porras Bucaro</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-inner">
                <h2 class="text-lg font-bold mb-4 text-[#002B5B] text-center">Progreso de la Capuchinera ☕</h2>
                
                <img id="img-capuchinera" src="capuchinera.webp" alt="Capuchinera Oster" class="w-full max-h-72 object-contain mx-auto mb-6 drop-shadow-md">

                <div class="w-full bg-slate-300 rounded-full h-7 mb-2 overflow-hidden shadow-inner border border-slate-300">
                    <div class="bg-gradient-to-r from-[#C5A059] to-[#E6C68A] h-7 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-3 <?php echo ($porcentaje >= 100) ? 'animate-pulse' : ''; ?>" style="width: <?php echo $ancho_barra; ?>%;">
                        <span class="text-xs font-bold text-[#002B5B]"><?php echo round($ancho_barra); ?>%</span>
                    </div>
                </div>
                <div class="flex justify-between text-sm font-bold text-[#002B5B]">
                    <span>Q<?php echo number_format($total_recaudado, 2); ?></span>
                    <span>Meta: Q<?php echo number_format($meta, 2); ?></span>
                </div>

                <?php if ($porcentaje >= 100): ?>
                    <div class="mt-6 bg-gradient-to-r from-yellow-100 to-amber-100 border-2 border-amber-300 p-4 rounded-xl text-center shadow-lg animate-bounce">
                        <p class="text-xl font-bold text-amber-800">🎉 ¡META ALCANZADA! 🎉</p>
                        <p class="text-amber-700 text-sm mt-1">¡Muchísimas gracias a todos! La capuchinera ya es una realidad. ☕💛</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        
        <div class="bg-[#002B5B] p-4 text-center text-white/70 text-sm border-t-2 border-[#C5A059]">
            Ingporras.com - Almuerzón Pérez © 2026
        </div>
    </div>
</body>
</html>