

function agregarEducacion() {
    let container = document.getElementById('educacion-container');
    let div = document.createElement('div');
    div.classList.add('educacion-item');
    div.innerHTML = `
        <hr>
        <input type="hidden" name="id_edu[]" value="0">
        <label>Institución:</label>
        <input type="text" name="institucion[]" required>
        
        <label>Título Carrera:</label>
        <input type="text" name="titulo_carrera[]" required>
        
        <label>Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio[]" required>
        
        <label>Fecha de Fin:</label>
        <input type="date" name="fecha_fin[]">
        
        <label>Actualidad:</label>
        <input type="checkbox" name="actualidad[]">
        
        <label>Nivel de Estudio:</label>
        <select name="nivel_estudio[]" required>
            <option value="primaria completa">Primaria Completa</option>
            <option value="primaria incompleta">Primaria Incompleta</option>
            <option value="secundario completo">Secundario Completo</option>
            <option value="secundario incompleto">Secundario Incompleto</option>
            <option value="terciario completo">Terciario Completo</option>
            <option value="terciario incompleto">Terciario Incompleto</option>
            <option value="universitario completo">Universitario Completo</option>
            <option value="universitario incompleto">Universitario Incompleto</option>
        </select>
        <button type="button" class="delete-button" onclick="eliminarEducacion(this)">Eliminar</button>
    `;
    container.appendChild(div);
}

function agregarExperiencia() {
    let container = document.getElementById('experiencia-container');
    let div = document.createElement('div');
    div.classList.add('experiencia-item');
    div.innerHTML = `
        <hr>
        <input type="hidden" name="id_exp[]" value="0">
        <label>Puesto:</label>
        <input type="text" name="puesto[]" required>
        
        <label>Empresa:</label>
        <input type="text" name="empresa[]" required>
        
        <label>Fecha de Ingreso:</label>
        <input type="date" name="fecha_inicio[]" required>
        
        <label>Fecha de Egreso:</label>
        <input type="date" name="fecha_fin[]">
        
        <label>Actualmente:</label>
        <input type="checkbox" name="actualidad[]">
        
        <label>Principales Tareas:</label>
        <textarea name="tareas[]" rows="4" required></textarea>
        
        <button type="button" class="delete-button" onclick="eliminarExperiencia(this)">Eliminar</button>
    `;
    container.appendChild(div);
}

function agregarIdioma() {
    let container = document.getElementById('idioma-container');
    let div = document.createElement('div');
    div.classList.add('idioma-item');
    div.innerHTML = `
        <hr>
        <input type="hidden" name="id_idioma[]" value="0">
        <label>Idioma:</label>
        <input type="text" name="idioma[]" required>
        
        <label>Nivel de Competencia:</label>
        <select name="nivel_competencia[]" required>
            <option value="oral">Oral</option>
            <option value="escrito">Escrito</option>
            <option value="nativo">Nativo</option>
        </select>
        
        <label>Nivel de Habilidad:</label>
        <select name="nivel_habilidad[]" required>
            <option value="basico">Básico</option>
            <option value="intermedio">Intermedio</option>
            <option value="experto">Experto</option>
        </select>
        <button type="button" class="delete-button" onclick="eliminarIdioma(this)">Eliminar</button>
    `;
    container.appendChild(div);
}

function eliminarEducacion(button) {
    if (confirm('¿Estás seguro de que deseas eliminar esta entrada de educación?')) {
        let id = button.parentElement.querySelector('input[name="id_edu[]"]').value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "cv_postulantes.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    button.parentElement.remove();
                } else {
                    alert('Error al eliminar la entrada de educación.');
                }
            }
        };
        xhr.send(`action=eliminar_educacion&id=${id}`);
    }
    
}
function eliminarExperiencia(button) {
    if (confirm('¿Estás seguro de que deseas eliminar esta entrada de experiencia?')) {
        let id = button.parentElement.querySelector('input[name="id_exp[]"]').value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "cv_postulantes.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    button.parentElement.remove();
                } else {
                    alert('Error al eliminar la entrada de experiencia.');
                }
            }
        };
        xhr.send(`action=eliminar_experiencia&id=${id}`);
    }
}
function eliminarIdioma(button) {
    if (confirm('¿Estás seguro de que deseas eliminar esta entrada de idioma?')) {
        let id = button.parentElement.querySelector('input[name="id_idioma[]"]').value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "cv_postulantes.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    button.parentElement.remove();
                } else {
                    alert('Error al eliminar idioma.');
                }
            }
        };
        xhr.send(`action=eliminar_idioma&id=${id}`);
    }
}