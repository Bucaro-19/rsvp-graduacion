<?php
session_start();
require_once 'config.php';

// --- CONFIGURACIÓN DE SEGURIDAD ---
// Cambia esta contraseña por la que tú quieras
$password_admin = "Capuchinera2026"; 

// Procesar el login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $password_admin) {
        $_SESSION['logueado'] = true;
    } else {
        $error_login = "Contraseña incorrecta";
    }
}

// Procesar cerrar sesión
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

// --- SI ESTÁ LOGUEADO, MOSTRAR DASHBOARD ---

// Consultas para las métricas
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

// Obtener todos los invitados
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
        // Función para copiar el mensaje de WhatsApp al portapapeles
        function copiarLink(nombre, token) {
            const url = `https://ingporras.com/?invitado=${token}`;
            // Extraemos el primer nombre para el mensaje
            const primerNombre = nombre.split(' ')[0];
            const mensaje = `¡Hola ${primerNombre}! Te comparto la invitación para mi celebración de graduación de Ingeniería. Por favor confirma tu asistencia en este enlace: ${url}`;
            
            navigator.clipboard.writeText(mensaje).then(() => {
                alert(`¡Mensaje para ${primerNombre} copiado al portapapeles!`);
            });
        }
    </script>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 font-sans text-slate-800">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Dashboard de Invitados</h1>
            <a href="?logout=true" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Cerrar Sesión</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
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

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-sm uppercase tracking-wider border-b border-slate-200">
                            <th class="p-4 font-medium">Nombre</th>
                            <th class="p-4 font-medium text-center">Estado</th>
                            <th class="p-4 font-medium text-right">Aporte</th>
                            <th class="p-4 font-medium text-center">Acción (Link)</th>
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
                                <td class="p-4 text-center">
                                    <button onclick="copiarLink('<?php echo addslashes($row['nombre']); ?>', '<?php echo $row['token']; ?>')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded text-sm font-medium transition border border-indigo-200">
                                        Copiar Msg
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>