<!DOCTYPE html>
<html>
<head>
    <title>List Làm Hôm Nay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .task-item { transition: all 0.3s ease; }
        .task-item:hover { background: #f1f1f1; }
        .completed { background-color: greenyellow; }
        .container { max-width: 700px; }
        .task-pending {
            background-color: #f0f0f0;
            text-decoration: line-through;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-center">📋 To-Do List <span id="today"></span></h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group shadow-sm">
            <input type="text" name="title" class="form-control" placeholder="Enter new task..." required>
            <button class="btn btn-primary">Add</button>
        </div>
    </form>

    <ul class="list-group shadow-sm">
        @forelse($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center task-item {{ $task->completed ? 'completed' : '' }}">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                        ✓
                    </button>
                </form>

                <span class="flex-fill mx-3 {{ $task->status == 'pending' ? 'task-pending' : '' }}">
                    {{ $task->title }}
                </span>

                <div class="btn-group">
                    <button class="btn btn-icon btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="{{ $task->id }}" data-title="{{ $task->title }}">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </button>
                    <form action="{{ route('tasks.pending', $task->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-pending"><i class="fa fa-clock"></i></button>
                    </form>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-icon btn-delete">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center">No tasks yet!</li>
        @endforelse
    </ul>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="title" id="taskTitle" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save changes</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');

            var modalTitleInput = document.getElementById('taskTitle');
            var form = document.getElementById('editForm');

            modalTitleInput.value = title;
            form.action = '/todo-app/public/tasks/' + id;
        });
    });
  const today = new Date();
  const day = String(today.getDate()).padStart(2, '0');
  const month = String(today.getMonth() + 1).padStart(2, '0');
  document.getElementById('today').textContent = `${day}/${month}`;
</script>

</body>
</html>
