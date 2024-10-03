const navToggle = document.getElementById('nav-toggle');
      const body = document.body;
  
      navToggle.addEventListener('change', function() {
          if (this.checked) {
              body.classList.add('sidebar-expanded');
          } else {
              body.classList.remove('sidebar-expanded');
          }
      });
      let tasks = [];
        let currentTaskIndex = -1;
        const statusElements = {
            'to-do': document.getElementById('todo-to-do'),
            'in-progress': document.getElementById('todo-in-progress'),
            'completed': document.getElementById('todo-completed')
        };

        document.addEventListener('DOMContentLoaded', () => {
            renderTasks();
        });

        function openTaskModal(status) {
            document.getElementById('task-status').value = status;
            document.getElementById('task-title').value = ''; // Limpar campos do formulário
            document.getElementById('task-description').value = '';
            currentTaskIndex = -1; // Resetar o índice da tarefa
            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }

        function saveTask() {
            const title = document.getElementById('task-title').value;
            const description = document.getElementById('task-description').value;
            const status = document.getElementById('task-status').value;

            if (title && description) {
                const task = { title, description, status, completed: false };

                if (currentTaskIndex > -1) {
                    tasks[currentTaskIndex] = task; // Atualizar tarefa existente
                } else {
                    tasks.push(task); // Adicionar nova tarefa
                }

                renderTasks();
                const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
                modal.hide();
            } else {
                alert('Por favor, preencha todos os campos.');
            }
        }

        function renderTasks() {
            // Clear columns, except the "Adicionar Tarefa" card
            Object.values(statusElements).forEach(col => {
                const cards = col.querySelectorAll('.todo-card:not(#add-task-card)');
                cards.forEach(card => card.remove());
            });

            // Render tasks
            tasks.forEach((task, index) => {
                const taskCard = document.createElement('div');
                taskCard.className = 'todo-card';
                if (task.completed) taskCard.classList.add('completed');

                taskCard.innerHTML = `
                    <button class="remove-task-btn" onclick="deleteTask(${index})">&times;</button>
                    <h5>${task.title}</h5>
                    <p>${task.description}</p>
                    <div class="task-actions">
                        <button class="btn btn-warning btn-task" onclick="markAsInProgress(${index})">Iniciar</button>
                        <button class="btn btn-success btn-task" onclick="markAsCompleted(${index})">Concluir</button>
                        <button class="btn btn-secondary btn-task" onclick="editTask(${index})">Renomear</button>
                    </div>
                `;

                statusElements[task.status].appendChild(taskCard);
            });

            // Atualiza os contadores
            updateTaskCounts();
        }

        function markAsInProgress(index) {
            tasks[index].status = 'in-progress';
            renderTasks();
        }

        function markAsCompleted(index) {
            tasks[index].completed = true;
            tasks[index].status = 'completed';
            renderTasks();
        }

        function editTask(index) {
            currentTaskIndex = index;
            document.getElementById('task-title').value = tasks[index].title;
            document.getElementById('task-description').value = tasks[index].description;
            document.getElementById('task-status').value = tasks[index].status;

            const modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.show();
        }

        function deleteTask(index) {
            tasks.splice(index, 1);
            renderTasks();
        }

        function updateTaskCounts() {
            const counts = { 'to-do': 0, 'in-progress': 0, 'completed': 0 };
            tasks.forEach(task => counts[task.status]++);

            document.getElementById('todo-to-do-count').innerText = counts['to-do'];
            document.getElementById('todo-in-progress-count').innerText = counts['in-progress'];
            document.getElementById('todo-completed-count').innerText = counts['completed'];
        }