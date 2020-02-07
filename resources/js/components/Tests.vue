<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Les Tests</h3>

                <div class="card-tools">
                   <button type="button" class="btn btn-success" @click="newModal">
                    <i class="fas fa-chalkboard-teacher"></i>
                  Ajouter un test
                </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Titre</th>
                      <th>Nom et prénom</th>
                      <th>effectué le</th>
                      <th>Note</th>
                      <th>Observation</th>
                      <th>Modification</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                <tr v-for="test in tests" :key="test.id">
                   
                      <td>{{test.id}}</td>
                      <td>{{test.titre}}</td>
                      <td>nom prénom</td>
                      <td>{{test.created_at}}</td>
                      <td>{{test.note}}</td>
                      <td>{{test.observation}}</td>
                    <td>
                        <button @click="editModal(test)"  class="btn btn-warning">
                      <i class="fas fa-edit"></i>
                    </button>
                      <button @click="deleteTests(test.id)" class="btn btn-danger">
                      <i class="fas fa-trash"></i>
                    </button>
                      </td>                      
                    </tr>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajouter un test</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
             <form @submit.prevent="editMode ? updateTest() : createTest()">
            <div class="modal-body">
            <div class="form-group">
                  <label>titre</label>
                  <input
                    v-model="form.titre"
                    type="text"
                    
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('titre') }"
                  />
                  <has-error :form="form" field="titre"></has-error>
                </div>
                
    <div class="form-group" v-show="!editMode" id="eleveSelect">
                  <label for="">Eleve</label>
                 <v-select  :class="form.errors.has('eleves_id') ? dropdownErrorEleve() : '' " v-model="form.eleves_id" :options="options_eleves" ></v-select>
                  
                </div>


               
                 <div class="form-group">
                  <label>note</label>
                  <input
                    v-model="form.note"
                    type="text"
                    
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('note') }"
                  />
                  <has-error :form="form" field="note"></has-error>
                </div>
                
              <div class="form-group">
                  <label>observation</label>
                  <textarea 
                   v-model="form.observation"
                        
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('observation') }"
                   cols="30" rows="4"></textarea>
                  <has-error :form="form" field="observation"></has-error>
                </div>
               
               
            </div>
            <div class="modal-footer ">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="submit" v-show="!editMode" class="btn btn-success">Valider</button>
                <button type="submit" v-show="editMode" class="btn btn-warning">modifier</button>

             
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        </div>
    </div>
</template>
<style>
     .alert_dropdown{
       border-color: #e3342f;
    
     }
    </style>

<script>
export default {
  
  data() {
    return {
      editMode: false,

        tests: [],
       options_eleves: [],
      
       

    form: new Form({
      id: "", 
      eleves_id: "",
      titre: "",
      note: "",
      observation: ""
    })
    }
  },
  methods: {
 /////////////////////

    updateTest(){

      this.form.put('/tests/'+ this.form.id)
      .then(()=>{
              this.$Progress.start();
              Swal.fire(
                "Modifié!",
                "Test a été modifié avec succés",
                "success"
              );
              Fire.$emit("triggerLoad");
          $("#modal-default").modal("hide");

              this.$Progress.finish();


        
      })
      .catch(()=>{
              this.$Progress.fail();
 Swal.fire({
              type: "error",
              title: "Oops...",
              text:
                "il y a un probléme de modification, contacter le dévloppeur!"
            });
      })
    },


    //////////////////////////////////////////////////////


//////////////////


    deleteTests(id) {
      Swal.fire({
        title: "êtes-vous sûre?",
        text: "Vous perdez les informations sur ce test!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "oui, supprimer!"
      }).then(result => {
        this.form
          .delete("/tests/" + id)
          .then(() => {
            if (result.value) {
              this.$Progress.start();

              Swal.fire(
                "Supprimé!",
                "Le test a été supprimé avec succés",
                "success"
              );
              Fire.$emit("triggerLoad");

              this.$Progress.finish();
            }
          })
          .catch(() => {
            Swal.fire({
              type: "error",
              title: "Oops...",
              text:
                "il y a un probléme de suppression, contacter le dévloppeur!"
            });
          });
      });
    },////////////////////////////////////////////////////////

/////////////////////
loadTests() {
      this.$Progress.start();
      axios.get("/tests/show/all").then(({ data }) => (this.tests = data));
      this.$Progress.finish();
    },
//////////////////////////////////
    createTest(){



 this.$Progress.start();
 this.form.eleves_id = this.form.eleves_id.split('-')[0];



      this.form
        .post("/tests")
        .then(() => {
          $("#modal-default").modal("hide");
          Swal.fire("Félicitation!", "Test crée avec suucés!", "success");
          Fire.$emit("triggerLoad");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    /////////////////////
     loadEleve() {
      this.$Progress.start();
      axios.get("/eleves/show/all").then(({ data }) => {
        this.eleves = data;
        this.options_eleves = data.map((val)=> val.id + '-'+ val.nom_prenom);
       
        
     });
      
     
      this.$Progress.finish();
    },
    /////////////////////////////
      
     dropdownErrorEleve(){
       document.querySelector('#eleveSelect .vs__dropdown-toggle').classList.add('alert_dropdown');
    },
    /////////////////////
     //////////////////////////////////////////////////////

    editModal(test){
      this.editMode = true;
     
          this.form.errors.clear();

      this.form.reset();
          $("#modal-default").modal("show");
      this.form.fill(test);      
    },


    //////////////////////////////////////////////////////

       //////////////////////////////////////////////////////

    newModal(){
 

       document.querySelector('#eleveSelect .vs__dropdown-toggle').classList.remove('alert_dropdown');

          this.form.errors.clear();
          this.form.reset();
          $("#modal-default").modal("show");

    },

    //////////////////////////////////////////////////////
  },
  created() {
    this.loadEleve();
    
    this.loadTests();

 Fire.$on("triggerLoad", () => {
      this.loadTests();
    });
       

  },
  mounted() {
     
  },
};
</script>
