<?php
session_start();
require_once 'config.php';

// --- CONFIGURACIÓN DE SEGURIDAD ---
$password_admin = "Capuchinera2026"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $password_admin) {
        $_SESSION['logueado'] = true;
    } else {
        $error_login = "Contraseña incorrecta";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// --- SI NO ESTÁ LOGUEADO, MOSTRAR LOGIN ---
if (!isset($_SESSION['logueado'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Graduación</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-sm w-full">
        <h2 class="text-2xl font-bold text-center mb-6 text-slate-800">Acceso Restringido 🛡️</h2>
        <?php if(isset($error_login)): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center text-sm"><?php echo $error_login; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="Contraseña" required class="w-full px-4 py-2 border rounded-lg mb-4 outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-2 rounded-lg hover:bg-slate-700 transition">Entrar al Dashboard</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

// --- LOGICA DEL CRUD ---

// 1. AGREGAR INVITADO
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nuevo_nombre = $conn->real_escape_string(trim($_POST['nuevo_nombre']));
    if (!empty($nuevo_nombre)) {
        $base_token = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nuevo_nombre));
        $nuevo_token = $base_token . '-' . rand(100, 999);
        $conn->query("INSERT INTO invitados (nombre, token) VALUES ('$nuevo_nombre', '$nuevo_token')");
        header("Location: admin.php");
        exit;
    }
}

// 2. ELIMINAR INVITADO
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_borrar = intval($_POST['id_borrar']);
    if ($id_borrar > 0) {
        $conn->query("DELETE FROM invitados WHERE id = $id_borrar");
        header("Location: admin.php");
        exit;
    }
}

// 3. EDITAR INVITADO (NOMBRE Y ESTADO)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_editar = intval($_POST['id_editar']);
    $nombre_editado = $conn->real_escape_string(trim($_POST['nombre_editado']));
    $estado_editado = $_POST['estado_editado']; // Puede ser 'null', '1', o '0'

    if ($id_editar > 0 && !empty($nombre_editado)) {
        // Lógica para el estado
        if ($estado_editado === 'null') {
            $asiste_sql = "NULL";
        } else {
            $asiste_sql = intval($estado_editado);
        }

        $conn->query("UPDATE invitados SET nombre = '$nombre_editado', asiste = $asiste_sql WHERE id = $id_editar");
        header("Location: admin.php");
        exit;
    }
}

// --- CONSULTAS PARA EL DASHBOARD ---

$res_total = $conn->query("SELECT SUM(aporte) as total FROM invitados");
$total_recaudado = $res_total->fetch_assoc()['total'] ?? 0;

$res_stats = $conn->query("
    SELECT 
        SUM(CASE WHEN asiste = 1 THEN 1 ELSE 0 END) as confirmados,
        SUM(CASE WHEN asiste = 0 THEN 1 ELSE 0 END) as declinados,
        SUM(CASE WHEN asiste IS NULL THEN 1 ELSE 0 END) as pendientes
    FROM invitados
");
$stats = $res_stats->fetch_assoc();

$invitados = $conn->query("SELECT * FROM invitados ORDER BY asiste DESC, nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Graduación</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Función para enlace normal
        function copiarLink(nombre, token) {
            const url = `https://ingporras.com/?invitado=${token}`;
            const primerNombre = nombre.split(' ')[0];
            const mensaje = `¡Hola ${primerNombre}! Te comparto la invitación para mi celebración de graduación de Ingeniería en Sistemas. Por favor confirma tu asistencia en este enlace: ${url}`;
            
            navigator.clipboard.writeText(mensaje).then(() => {
                alert(`¡Mensaje para ${primerNombre} copiado al portapapeles!`);
            });
        }

        // Función para enlace de último día
        function copiarRecordatorio(nombre, token) {
            const url = `https://ingporras.com/?invitado=${token}`;
            const primerNombre = nombre.split(' ')[0];
            const mensaje = `¡Hola ${primerNombre}! 👋 Espero que estés muy bien. Te escribo para dejarte un recordatorio súper amigable de mi celebración de graduación. Hoy 1 de abril es el último día para confirmar, ya que debo enviar el listado final al restaurante para los platillos. Por favor, ayúdame confirmando tu asistencia (o si no puedes ir) en este enlace: ${url} \n\n¡Si no puedes acompañarme no te preocupes, lo entiendo perfectamente! Un abrazo grande.`;
            
            navigator.clipboard.writeText(mensaje).then(() => {
                alert(`¡Recordatorio amigable para ${primerNombre} copiado al portapapeles!`);
            });
        }

        // Funciones para el Modal de Edición Profesional
        function abrirModalEditar(id, nombreActual, estadoActual) {
            document.getElementById('input-id-editar').value = id;
            document.getElementById('input-nombre-editado').value = nombreActual;
            document.getElementById('select-estado-editado').value = estadoActual;
            
            // Mostrar el modal
            document.getElementById('modal-editar').classList.remove('hidden');
        }

        function cerrarModalEditar() {
            document.getElementById('modal-editar').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 font-sans text-slate-800">

    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-slate-800">Dashboard de Invitados</h1>
            <a href="?logout=true" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">Cerrar Sesión</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-blue-500">
                <p class="text-sm text-slate-500 font-medium">Recaudado (Capuchinera)</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">Q<?php echo number_format($total_recaudado, 2); ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-green-500">
                <p class="text-sm text-slate-500 font-medium">Confirmados</p>
                <p class="text-3xl font-bold text-slate-800 mt-2"><?php echo $stats['confirmados'] ?? 0; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-red-500">
                <p class="text-sm text-slate-500 font-medium">No Asistirán</p>
                <p class="text-3xl font-bold text-slate-800 mt-2"><?php echo $stats['declinados'] ?? 0; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-yellow-500">
                <p class="text-sm text-slate-500 font-medium">Pendientes</p>
                <p class="text-3xl font-bold text-slate-800 mt-2"><?php echo $stats['pendientes'] ?? 0; ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8">
            <form method="POST" action="" class="flex flex-col md:flex-row gap-4 items-end">
                <input type="hidden" name="action" value="add">
                <div class="flex-grow w-full">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Agregar Nuevo Invitado</label>
                    <input type="text" name="nuevo_nombre" placeholder="Nombre completo o apodo del invitado" required class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-sm">
                    + Agregar
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-sm uppercase tracking-wider border-b border-slate-200">
                            <th class="p-4 font-medium">Nombre</th>
                            <th class="p-4 font-medium text-center">Estado</th>
                            <th class="p-4 font-medium text-right">Aporte</th>
                            <th class="p-4 font-medium text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php while($row = $invitados->fetch_assoc()): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-medium text-slate-800"><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td class="p-4 text-center">
                                    <?php if($row['asiste'] === '1'): ?>
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Confirmado</span>
                                    <?php elseif($row['asiste'] === '0'): ?>
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">No asiste</span>
                                    <?php else: ?>
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right font-medium text-slate-600">
                                    Q<?php echo number_format($row['aporte'], 2); ?>
                                </td>
                                <td class="p-4 text-center flex justify-center gap-2 flex-wrap">
                                    <button onclick="copiarLink('<?php echo addslashes($row['nombre']); ?>', '<?php echo $row['token']; ?>')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded text-sm font-medium transition border border-indigo-200" title="Mensaje Original">
                                        Msg
                                    </button>
                                    
                                    <button onclick="copiarRecordatorio('<?php echo addslashes($row['nombre']); ?>', '<?php echo $row['token']; ?>')" class="bg-sky-50 text-sky-600 hover:bg-sky-100 px-3 py-1.5 rounded text-sm font-medium transition border border-sky-200" title="Enviar Recordatorio">
                                        Rec
                                    </button>

                                    <?php 
                                        // Definir qué mandar al JS: '1', '0' o 'null'
                                        $estado_para_js = is_null($row['asiste']) ? 'null' : $row['asiste']; 
                                    ?>
                                    <button onclick="abrirModalEditar(<?php echo $row['id']; ?>, '<?php echo addslashes($row['nombre']); ?>', '<?php echo $estado_para_js; ?>')" class="bg-amber-50 text-amber-600 hover:bg-amber-100 px-3 py-1.5 rounded text-sm font-medium transition border border-amber-200">
                                        Editar
                                    </button>

                                    <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a <?php echo addslashes($row['nombre']); ?>?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id_borrar" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded text-sm font-medium transition border border-red-200">
                                            Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-editar" class="fixed inset-0 bg-slate-900 bg-opacity-60 hidden flex items-center justify-center z-50 px-4">
        <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-sm transform transition-all">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-slate-800">Editar Invitado</h3>
                <button onclick="cerrarModalEditar()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="form-editar" method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_editar" id="input-id-editar">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nombre o Apodo</label>
                    <input type="text" name="nombre_editado" id="input-nombre-editado" required class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-amber-500 transition">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Estado de Confirmación</label>
                    <select name="estado_editado" id="select-estado-editado" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-amber-500 transition">
                        <option value="null">⏳ Pendiente</option>
                        <option value="1">✅ Confirmado (Sí asiste)</option>
                        <option value="0">❌ No asiste</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="cerrarModalEditar()" class="px-5 py-2 text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg font-bold transition">Cancelar</button>
                    <button type="submit" class="px-5 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold transition shadow-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>