import './bootstrap';
import Sortable from 'sortablejs';

document.addEventListener('DOMContentLoaded', () => {
    iniciarDragDrop();
    iniciarBuscador();
});

function iniciarDragDrop() {
    const listas = document.querySelectorAll('.task-list');
    if (!listas.length) return;

    listas.forEach(list => {
        new Sortable(list, {
            group: 'tasks',
            animation: 150,

            onEnd: function (evt) {
                let taskId = evt.item.dataset.id;
                let newStatus = evt.to.id;

                fetch('/tasks/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: taskId,
                        estado: newStatus
                    })
                }).then(() => location.reload());
            }
        });
    });
}

let tareaActualId = null;

// 🌍 funciones globales para Blade
window.editarTask = function(task) {
    tareaActualId = task.id;

    document.getElementById('editTitulo').value = task.titulo;
    document.getElementById('editDescripcion').value = task.descripcion;
    document.getElementById('editEstado').value = task.estado;

    document.getElementById('modal').classList.remove('hidden');
}

window.cerrarModal = function() {
    document.getElementById('modal').classList.add('hidden');
    tareaActualId = null;
}

window.guardarCambios = function() {
    const titulo = document.getElementById('editTitulo').value;
    const descripcion = document.getElementById('editDescripcion').value;
    const estado = document.getElementById('editEstado').value;

    fetch(`/tasks/${tareaActualId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            titulo,
            descripcion,
            estado
        })
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Error al actualizar la tarea');
        }
    })
    .catch(error => console.error('Error:', error));
}

function iniciarBuscador() {
    const buscador = document.getElementById('buscador');
    if (!buscador) return;

    buscador.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const tasks = document.querySelectorAll('.task');

        tasks.forEach(task => {
            const titulo = task.dataset.titulo || '';
            const descripcion = task.dataset.descripcion || '';

            task.style.display =
                titulo.includes(term) || descripcion.includes(term)
                    ? ''
                    : 'none';
        });
    });
}