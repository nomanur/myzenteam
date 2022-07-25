<template>

<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <h2>Admin Panel</h2>
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <p>Pdf Upload Form</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      
      <form v-if="!edit" v-on:submit.prevent="Upload" ref="pdfform">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" class="form-control" v-model="title" id="exampleFormControlInput1" placeholder="title of the pdf">
        <br>
        <span class="text-danger" v-if='errors.title'>{{errors.title[0]}}</span>
      </div>
      <hr>
      <div class="mb-3">
        <label for="formFile" class="form-label">Upload file here</label>
        <input ref='pdf' class="form-control" type="file" id="formFile">
      
        <br>
        <span class="text-danger" v-if='errors.file'>{{errors.file[0]}}</span>
      </div>
      <button class="btn-primary" type="submit">Submit</button>
      </form>
      <!-- update form -->
      <form v-else v-on:submit.prevent="Update" ref="pdfform">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" class="form-control" v-model="title" id="exampleFormControlInput1" placeholder="title of the pdf">
        <br>
        <span class="text-danger" v-if='errors.title'>{{errors.title[0]}}</span>
      </div>
      <hr>
      <div class="mb-3">
        <label for="formFile" class="form-label">Upload file here</label>
        <input ref='pdf' class="form-control" type="file" id="formFile">
      
        <br>
        <span class="text-danger" v-if='errors.file'>{{errors.file[0]}}</span>
      </div>
      <button class="btn-primary" type="submit">Update</button>
      <button class="btn-primary mx-2" type="submit" v-on:click="clear">Create</button>
      </form>


    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <p>Pdf Table</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <span class="text-danger" v-if='msg'>{{msg}}</span>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Pdf</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody v-if="allpdf.length > 0">
          <tr v-for="(getpdf, index) in allpdf" :key="index">
            <th scope="row">{{++index}}</th>
            <td>{{getpdf.title}}</td>
            <td class="download" @click="pdfDownlaod(getpdf.id)">{{getpdf.file}}</td>
            <td>
              <button class="btn-warning" @click="editPdf(getpdf.id)">Edit</button>
              <button class="btn-danger" @click="DeletePdf(getpdf.id)">Delete</button>
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
import { onMounted, ref } from 'vue';
const pdfform = ref();
const allpdf = ref([]);
const msg =  ref('')
const edit = ref(false)
const editId = ref();

const pdf = ref(null);
const title = ref('');
const errors = ref({});
const Upload = ()=>{
    let formData = new FormData()
      formData.append('file', pdf.value.files[0])
      formData.append('title', title.value)

      axios.post('/api/pdfupload', formData)
      .then(function(response){
        getpdf()
        title.value ='',
        pdf.value.value=null
        msg.value = 'PDF Created successfully'
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}

const DeletePdf = function(id){
  if (window.confirm("Delete?"))
  { 
    axios.delete("/api/pdf/" + id +"/delete")
    .then(function(response){
      msg.value = 'PDF deleted successfully'
      getpdf();
    })
    .catch(function(error){
      errors.value = error.response.data.errors;
    })
  }
}

const pdfDownlaod = function(id){
  axios.get('/api/getpdf/download/'+ id)
  .then(function(response){
     console.log('download');
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}

const editPdf = function(id){
  axios.get('/api/getpdf/'+ id)
  .then(function(response){
      title.value =response.data.pdf.title
      edit.value = true
      editId.value = id
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}

const Update = function(){
   let formData = new FormData()
  formData.append('file', pdf.value.files[0])
  formData.append('title', title.value)
      axios.post('/api/getpdf/'+editId.value+'/update', formData)
      .then(function(response){
        console.log(response);
        getpdf()
        title.value ='',
        pdf.value.value=null
        msg.value = 'PDF Updated Successfully'
        edit.value = false
      })
      .catch(function(error){
        errors.value = error.response.data.errors;
      })
}


const clear = function(){
  title.value = ''
  edit.value = false
}

const getpdf = function(){
  axios.get('/api/getpdf')
  .then(function(response){
    allpdf.value = (response.data.pdf);
  })
  .catch(function(error){
    errors.value = error.response.data.errors;
  })
}

onMounted(() => {
  getpdf()
})
</script>

<style scoped>
.download{
  cursor: pointer;
  text-decoration: underline;
}
</style>