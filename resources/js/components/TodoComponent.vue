<template>
    <div class="container">
        <div class="row mt-2">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">Todo List </div>
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Deadline</th>
                    <th scope="col" class="text-center" style="width: 200px">Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(todo, index) in todos" :key="index">
                    <th scope="row">{{ ++ index }}</th>
                    <td>{{ todo.title }}</td>
                    <td>{{ todo.description.slice(0, 50) }}</td>
                    <td>{{ todo.deadline }}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-primary" @click="editTask(todo.id)">Edit</button>
                      <button type="button" class="btn btn-sm  btn-outline-success" @click="updateTaskStatus(todo.id)">Done</button>
                      <button type="button" class="btn btn-sm  btn-outline-danger" @click="deleteTask(todo.id)">Delete</button>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">Todo Form</div>
              <div class="card-body">
                  <div class="inputs-area mb-2">
                    <div class="mb-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" class="form-control" id="title" aria-describedby="title" v-model="input_title">
                    </div>
                    <div class="mb-3">
                      <label for="description" class="form-label">Description</label>
                      <textarea class="form-control" placeholder="Leave a description here" id="description" style="height: 100px" v-model="input_description"></textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input class="form-control" type="date" id="deadline" v-model="input_deadline">
                      </div>

                      <div class="col-md-6 mb-3">
                        <label for="assign" class="form-label">Assign</label>
                        <select v-model="input_assigned_to" class="form-select" aria-label="Default select example">
                          <option selected>Please select one</option>
                          <option  v-for="(user, index) in users" v-bind:value="user.id">{{ user.email }}</option>
                        </select>
                      </div>
                    </div>


                    <button v-if="add_task" type="button" class="btn btn-primary" @click="saveTask()">Add</button>

                    <button v-else type="button" class="btn btn-primary" @click="updateTask(update_task_id)">Update</button>
                  </div>
                  <button type="button" class="btn btn-warning" @click="resetInputs()">Clear Inputs</button>
                </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
      data(){
        return{
          todos:[],
          api: 'https://tt-todo.test/api/todos',
          users_api: 'https://tt-todo.test/api/users',
          update_task_status_api: 'https://tt-todo.test/api/update-task-status',
          input_title: '',
          input_description: '',
          input_deadline: '',
          input_assigned_to: '',
          add_task: true,
          update_task_id: '',
          users: [],
        }
      },
      mounted() {
        // Get api data
        this.axios.get(this.api).then(res=>{
         this.todos = res.data;
        });

        this.axios.get(this.users_api).then(res=>{
          this.users = res.data;
        });
      },
      methods:{
        saveTask(){
          if (this.input_title.length > 0 && this.input_description.length > 0 && this.input_deadline.length > 0){
            let data = {
              'title': this.input_title,
              'description': this.input_description,
              'deadline': this.input_deadline,
              'assigned_to': this.input_assigned_to
            };

            this.axios.post(this.api, data).then(res=>{
              this.todos.push(res.data);
              this.data = '';

              this.$toast.show('Task created!', {
                type: 'success',
                // all of other options may go here
                position: 'bottom-right'
              });
            })
          }
        },
        editTask(id){
          let index = this.todos.findIndex(object => {
            return object.id === id;
          });

          if (index >= 0){
            this.input_title = this.todos[index].title;
            this.input_description = this.todos[index].description;
            this.input_deadline = this.todos[index].deadline;
            this.input_assigned_to = this.todos['index'].assigned_to;
            this.add_task = false;
            this.update_task_id = id;
          }

        },
        updateTask(id){
          let index = this.todos.findIndex(object => {
            return object.id === id;
          });

          if (this.input_title.length > 0 && this.input_description.length > 0 && this.input_deadline.length > 0){
            let data = {'title': this.input_title, 'description': this.input_description, 'deadline': this.input_deadline, 'assigned_to': this.input_assigned_to};

            this.axios.put(this.api+'/'+id, data).then(res=>{
              this.todos[index].title = res.data.title;
              this.todos[index].description = res.data.description;
              this.todos[index].deadline = res.data.deadline;
              this.todos[index].assigned_to = res.data.assigned_to;
              this.resetInputs();

              this.$toast.show('Task updated!', {
                type: 'success',
                // all of other options may go here
                position: 'bottom-right'
              });
            })
          }
        },
        deleteTask(id){
          let index = this.todos.findIndex(object => {
            return object.id === id;
          });

          if (index >= 0){
            this.axios.delete(this.api+'/'+id).then(res=>{
              this.todos.splice(index,1);

              this.$toast.show('Task deleted!', {
                type: 'success',
                // all of other options may go here
                position: 'bottom-right'
              });
            })
          }
        },
        updateTaskStatus(id){
          let data = {'status': 1};

          let index = this.todos.findIndex(object => {
            return object.id === id;
          });

          if (index >= 0){
            this.axios.post(this.update_task_status_api+'/'+id, data).then(res=>{
              this.todos.splice(index,1);

              this.$toast.show('Task completed!', {
                type: 'success',
                // all of other options may go here
                position: 'bottom-right'
              });
            })
          }
        },
        resetInputs(){
          this.input_title = '';
          this.input_description = '';
          this.input_deadline = '';
          this.add_task = true;
          this.update_task_id = '';
        },

      }
    }
</script>
