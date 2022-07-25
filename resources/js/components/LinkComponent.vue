<template>
  <div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2>Link Form</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <label for="">Title</label>
            <input type="text" placeholder="title" class="form-control" v-model="title">
            <br>
            <label for="link">Link</label>
             <input type="text" placeholder="https://www.google.com" id="link" class="form-control" v-model="link">
            <br>
            <input type="checkbox" v-model="newtab"> Open in a new tab
             <br>
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
      <p>Link Table</p>
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
            <th scope="col">Link</th>
            <th scope="col">New Tab</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody v-if="allinks.length > 0">
          <tr v-for="(link, index) in allinks" :key="index">
            <th scope="row">{{++index}}</th>
            <td>{{link.title}}</td>
            <td>{{link.link}}</td>
            <td>{{link.newtab == 1 ? 'Open with new tab' : 'open in the current tab'}}</td>
            <td>
              <button class="btn-warning" @click="editLink(link.id)">Edit</button>
              <button class="btn-danger" @click="deleteLink(link.id)">Delete</button>
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

const title = ref('')
const link = ref('')
const newtab = ref(false)
const msg = ref('')
const errors = ref({})
const allinks = ref ([])
const editLinkId = ref()
const edit = ref(false)

const store = ()=>{
      let formData = new FormData()
      formData.append('title', title.value)
      formData.append('link', link.value)
      formData.append('newtab', newtab.value)

      axios.post('/api/link/create', formData)
      .then(function(response){
        getlinks()
        title.value =''
        link.value =''
        newtab.value =''
        msg.value = 'Snippet Created successfully'
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}

const editLink = function(id){
      axios.get('/api/link/'+ id)
        .then(function(response){
            title.value = response.data.link.title
            link.value = response.data.link.link
            newtab.value = response.data.link.newtab == 1 ? true : false
            editLinkId.value = id
            edit.value= true
        })
        .catch(function(error){
            errors.value = error.response.data.errors;
        })
}


const update = function(){
    let formData = new FormData()
    formData.append('title', title.value)
    formData.append('link', link.value)
    formData.append('newtab', newtab.value)

      axios.post('/api/link/'+editLinkId.value+'/update', formData)
      .then(function(response){
        getlinks()
        title.value= ''
        link.value= ''
        newtab.value= false
        msg.value = 'Link Updated Successfully'
        edit.value = false
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}

const deleteLink = function(id){
    if (window.confirm("Delete?"))
  { 
    axios.delete("/api/link/" + id +"/delete")
    .then(function(response){
      msg.value = 'Link deleted successfully'
      getlinks();
    })
    .catch(function(error){
      errors.value = error.response.data.errors;
    })
  }
}

const getlinks = function(){
  axios.get('/api/link')
  .then(function(response){
    allinks.value = response.data.link;
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}

const clear = function(){
    title.value= ''
    link.value= ''
    newtab.value= false
    edit.value = false
}


onMounted(() => {
  getlinks()
})
</script>

<style scoped>
</style>