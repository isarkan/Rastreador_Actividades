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