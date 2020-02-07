<template>
  <div class="container">
  
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Les Mois</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-success"
                  @click="newModal"
              >
                <i class="fas fa-calendar-plus"></i>
                Ajouter un mois
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
                  <th>Eleve</th>
                  <th>Seances</th>
                  <th>Début le</th>
                  <th>cloturé le</th>
                  
                  <th>Payement</th>
                  <th>Modification</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="unMois in mois" :key="unMois.id">
                
                  <td>{{ unMois.id }}</td>
                  
                  <td>{{ unMois.titre }}</td>
                 
                  <td>{{unMois.eleve}}</td>
                  <!--  -->
                  <td>{{unMois.nbr_seance}}/4</td>

                  <td>{{ unMois.created_at == null ? 'en attente' : unMois.created_at }}</td>
                  
                  <td>{{ unMois.updated_at == null ? 'en attente' : unMois.updated_at }}</td>

                  <!--  -->
                 
                  <td>{{ unMois.payments_id == null ? 'non payé' : 'payé' }}</td>

                  
                  <td>
                    <router-link :to="/mois/ + unMois.id" role="button" class="btn btn-primary">
                      <i class="fas fa-info-circle"></i>
                    </router-link>
                   <button @click="deleteMois(unMois.id)" class="btn btn-danger">
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
              <h4 class="modal-title">Ajouter un mois</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form @submit.prevent="createMois">
              <div class="modal-body">
                 <div class="form-group">
                  <label>Titre</label>
                  <input
                    v-model="form.titre"
                    type="text"
                    
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('titre') }"
                  />
                  <has-error :form="form" field="titre"></has-error>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Eleve</label>
                  
              
                 <v-select  :class="form.errors.has('eleves_id') ? dropdownError() : '' " v-model="form.eleves_id" :options="options"></v-select>
                 <small v-show="form.errors.has('eleves_id')" style="color: red">veuillez choisir un éléve!</small>
               
                  
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Valider</button>
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
      mois: [],
      eleves: [],
       options: [
        
    ],
    form: new Form({
      id: "", 
      titre: "",
      eleves_id: "",
      nbr_seance:""
     
    })
    }
  },
  methods: {



    //////////////////////////////////////////////////////
    deleteMois(id) {
      Swal.fire({
        title: "êtes-vous sûre?",
        text: "Vous perdez les informations sur ce mois!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "oui, supprimer!"
      }).then(result => {
        this.form
          .delete("/mois/" + id)
          .then(() => {
            if (result.value) {
              this.$Progress.start();

              Swal.fire(
                "Supprimé!",
                "Le mois a été supprimé avec succés",
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
loadMois() {
      this.$Progress.start();
      axios.get("/mois/show/all").then(({ data }) => (this.mois = data));
      this.$Progress.finish();
    },
//////////////////////////////////
    createMois(){



 this.$Progress.start();
 this.form.eleves_id = this.form.eleves_id.split('-')[0];



      this.form
        .post("/mois")
        .then(() => {
          $("#modal-default").modal("hide");
          Swal.fire("Félicitation!", "Mois crée avec suucés!", "success");
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
        this.options = data.map((val)=> val.id + '-'+ val.nom_prenom);
       
        
     });
      
     
      this.$Progress.finish();
    },
    /////////////////////////////
    dropdownError(){
       document.querySelector('.vs__dropdown-toggle').classList.add('alert_dropdown');
    },
    /////////////////////
       //////////////////////////////////////////////////////

    newModal(){
      this.editMode = false;

       document.querySelector('.vs__dropdown-toggle').classList.remove('alert_dropdown');

          this.form.errors.clear();
          this.form.reset();
          $("#modal-default").modal("show");

    },

    //////////////////////////////////////////////////////
  },
  created() {
    this.loadEleve();
    this.loadMois();

 Fire.$on("triggerLoad", () => {
      this.loadMois();
    });
       

  },
  mounted() {
      $('#selectMois').selectize({
      
      sortField: 'text'
        });
  },
};
</script>
