<template>
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Html Form</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <label for="">Title</label>
            <input type="text" placeholder="title" class="form-control" v-model="title">
            <br>
            <label for="floatingTextarea">Snippet Description</label>
             <textarea v-model="content" class="form-control" placeholder="Description" id="floatingTextarea"></textarea>
            <br>
            <label for="snippet">HTML snippet</label>
             <textarea v-model="snippet" class="form-control" placeholder="<p>Hello World</p>" id="snippet"></textarea>
            <br>
            <button v-if="!edit" class="btn-primary" @click="store" type="submit">Submit</button>
            <button v-if="edit" class="btn-primary" @click="update" type="submit">Update</button>
            <button v-if="edit" class="btn-primary mx-2" type="submit" v-on:click="clear">Create</button>
        </div>
    </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <p>Snippet Table</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
        <span class="text-danger" v-if='msg'>{{msg}}</span>
        <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Snippet</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody v-if="allsnippet.length > 0">
          <tr v-for="(snippet, index) in allsnippet" :key="index">
            <th scope="row">{{++index}}</th>
            <td>{{snippet.title}}</td>
            <td>{{snippet.content}}</td>
            <td>{{snippet.snippet}}</td>
            <td>
              <button class="btn-warning" @click="editSnippet(snippet.id)">Edit</button>
              <button class="btn-danger" @click="deleteSnippet(snippet.id)">Delete</button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <th scope="row"></th>
            <td></td>
            <td>Nothing to Show</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
const content = ref('')
const title = ref('')
const snippet = ref('')
const msg =  ref('')
const errors = ref({});
const allsnippet = ref([]);
const editSnippetId = ref();
const edit = ref(false);

const store = ()=>{
      let formData = new FormData()
      formData.append('title', title.value)
      formData.append('content', content.value)
      formData.append('snippet', snippet.value)

      axios.post('/api/snippet/create', formData)
      .then(function(response){
        getSnippet()
        title.value =''
        content.value =''
        snippet.value =''
        msg.value = 'Snippet Created successfully'
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}

const deleteSnippet = function(id){
    if (window.confirm("Delete?"))
  { 
    axios.delete("/api/snippet/" + id +"/delete")
    .then(function(response){
      msg.value = 'Snippet deleted successfully'
      getSnippet();
    })
    .catch(function(error){
      errors.value = error.response.data.errors;
    })
  }
}


const editSnippet = function(id){
     axios.get('/api/snippet/'+ id)
  .then(function(response){
      console.log(response);
      title.value = response.data.snippet.title
      content.value = response.data.snippet.content
      snippet.value = response.data.snippet.snippet
      editSnippetId.value = id
      edit.value= true
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}

const update = function(){
    let formData = new FormData()
    formData.append('title', title.value)
    formData.append('content', content.value)
    formData.append('snippet', snippet.value)

      axios.post('/api/snippet/'+editSnippetId.value+'/update', formData)
      .then(function(response){
        getSnippet()
        title.value= ''
        content.value= ''
        snippet.value= ''
        msg.value = 'Snippet Updated Successfully'
        edit.value = false
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}

const clear = function(){
   title.value= ''
   content.value= ''
   snippet.value= ''
   edit.value = false
}

const getSnippet = function(){
  axios.get('/api/snippet')
  .then(function(response){
    allsnippet.value = (response.data.snippet);
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}



onMounted(() => {
  getSnippet()
})
</script>

<style scoped>
.download{
  cursor: pointer;
  text-decoration: underline;
}
</style>