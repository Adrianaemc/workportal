<?php
session_start();

// Verificar si la empresa está autenticada
if (!isset($_SESSION['empresa'])) {
    header("Location: login_empresa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Vacante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include 'templates/header.php'; ?>
    </header>
    <div class="container">
        <h2>Publicar una nueva vacante</h2>
        <form id="form-vacante" action="procesar_publicacion_vacante.php" method="post">
            <div class="form-group">
                <label for="titulo">Título de la vacante</label>
                <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título de la vacante" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción de la vacante</label>
                <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción de la vacante" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="provincia">Provincia</label>
                <input type="text" id="provincia" name="provincia" class="form-control" placeholder="Provincia" required>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad</label>
                <input type="text" id="localidad" name="localidad" class="form-control" placeholder="Localidad" required>
            </div>
            <div class="form-group">
                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" class="form-control" placeholder="País" required>
            </div>
            <div class="form-group">
                <label for="salario">Salario</label>
                <input type="number" id="salario" name="salario" class="form-control" placeholder="Salario" required>
            </div>
            <div class="form-group">
                <label for="modalidad">Modalidad</label>
                <select id="modalidad" name="modalidad" class="form-control" required>
                    <option value="Remoto">Remoto</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Híbrido">Híbrido</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nivel_laboral">Nivel Laboral</label>
                <select id="nivel_laboral" name="nivel_laboral" class="form-control" required>
                    <option value="Junior">Junior</option>
                    <option value="Senior">Senior</option>
                    <option value="Jefe/Supervisor">Jefe/Supervisor</option>
                    <option value="Gerencia">Gerencia</option>
                    <option value="Sin Experiencia">Sin Experiencia</option>
                    <option value="Pasante">Pasante</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="carga_horaria">Carga Horaria</label>
                <select id="carga_horaria" name="carga_horaria" class="form-control" required>
                    <option value="Part-time">Part-time</option>
                    <option value="Full-time">Full-time</option>
                </select>
            </div>
            <div class="form-group">
                <label for="area">Area</label>
                <select id="area" name="area" class="form-control" required>
                    <option value="Administracion, contabilidad y finanzas">Administracion, contabilidad y finanzas</option>
                    <option value="Oficios y otros">Oficios y otros</option>
                    <option value="Atencion al cliente">Atencion al cliente</option>
                    <option value="Call center">Call center</option>
                    <option value="Salud">Salud</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Ingenierias">Ingenierias</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Tecnologia, sistemas y telecomunicaciones">Tecnologia, sistemas y telecomunicaciones</option>
                    <option value="Educacion">Educacion</option>
                    <option value="Diseño">Diseño</option>
                    <option value="Seguros">Seguros</option>

                
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>
    </div>
<footer>
    <?php include 'templates/footer.php'; ?>
</footer>
</body>
</html>
