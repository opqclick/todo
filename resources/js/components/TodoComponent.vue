<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todo </div>

                    <div class="card-body">
                      <div class="inputs-area">
                        <div class="mb-3">
                          <label for="title" class="form-label">Title</label>
                          <input type="text" class="form-control" id="title" aria-describedby="title" v-model="input_title">
                        </div>
                        <div class="mb-3">
                          <label for="description" class="form-label">Description</label>
                          <textarea class="form-control" placeholder="Leave a description here" id="description" style="height: 100px" v-model="input_description"></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="deadline" class="form-label">Deadline</label>
                          <input class="form-control" type="datetime-local" id="deadline" v-model="input_deadline">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                </div>

              <div class="card mt-2">
                <div class="card-header">Todos </div>
                <div class="card-body">
                  <table class="table">
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
                      <th scope="row">{{ ++index }}</th>
                      <td>{{ todo.title }}</td>
                      <td>{{ todo.description.slice(0, 50) }}</td>
                      <td>{{ todo.deadline }}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                        <button type="button" class="btn btn-sm  btn-outline-success">Complete</button>
                        <button type="button" class="btn btn-sm  btn-outline-danger">Delete</button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <td>

                      </td>
                      </td>
                    </tr>

                    </tbody>
                  </table>
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
          input_title: '',
          input_description: '',
          input_deadline: '',

        }
      },
      mounted() {
        // Get api data
       this.axios.get(this.api).then(res=>{
         this.todos = res.data;
       })
      }
    }
</script>
