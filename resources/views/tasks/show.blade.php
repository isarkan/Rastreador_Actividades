<h2>Detalle de la tarea</h2>

<p><strong>Título:</strong> {{ $task->titulo }}</p>
<p><strong>Estado:</strong> {{ $task->estado }}</p>

<hr>

<h3>Historial</h3>

@forelse($task->historial->sortByDesc('created_at') as $item)
    <div style="margin-bottom:10px; padding:10px; border:1px solid #ccc;">
        <strong>{{ $item->usuario->name ?? 'Sistema' }}</strong>
        {{ $item->accion }} <br>

        <small>
            {{ $item->estado_anterior }} → {{ $item->estado_nuevo }}
        </small><br>

        <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
    </div>
@empty
    <p>No hay historial</p>
@endforelse