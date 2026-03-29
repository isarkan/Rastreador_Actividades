import './bootstrap';

import Sortable from 'sortablejs';

document.querySelectorAll('.task-list').forEach(list => {

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

            })
                .then(() => {

                    location.reload();

                });
        }
    });

});

let taskIdActual = null;

window.editarTask = function(id, titulo, descripcion, estado) {

    taskIdActual = id;

    document.getElementById('editTitulo').value = titulo;
    document.getElementById('editDescripcion').value = descripcion;
    document.getElementById('editEstado').value = estado;

    document.getElementById('modal').classList.remove('hidden');
}

window.cerrarModal = function() {
    document.getElementById('modal').classList.add('hidden');
}

window.guardarCambios = function() {

    fetch('/tasks/update', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },

        body: JSON.stringify({
            id: taskIdActual,
            titulo: document.getElementById('editTitulo').value,
            descripcion: document.getElementById('editDescripcion').value,
            estado: document.getElementById('editEstado').value
        })

    })
    .then(() => location.reload());

}