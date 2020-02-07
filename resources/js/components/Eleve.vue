<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Les éléves</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-success"
                @click="newModal"
              >
                <i class="fas fa-user-plus"></i>
                Ajouter un éléve
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom et prénom</th>
                  <th>Type</th>
                  <th>Année</th>

                  <th>N° Tel</th>
                  <th>Date d'inscription</th>
                  <th>Nbr Mois</th>
                  <th>Modification</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="eleve in eleves" :key="eleve.id">
                  <td>{{ eleve.id }}</td>
                  <td>{{ eleve.nom_prenom }}</td>
                  <td>{{ eleve.type }}</td>
                  <td>{{ eleve.annee }}</td>

                  <td>{{ eleve.num_tel }}</td>

                  <td>{{ eleve.created_at | myDate}}</td>
                  <td>{{eleve.mois_count}} Mois</td>
                  <td>
                    <button @click="editModal(eleve)"  class="btn btn-warning">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button @click="deleteEleve(eleve.id)" class="btn btn-danger">
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
              <h4 class="modal-title">{{ editMode ? 'Modifier' : 'Ajouter' }} un éléve</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form @submit.prevent="editMode ? updateEleve() : createEleve()">
              <div class="modal-body">
                <!-- /////////// -->

                <div class="form-group">
                  <label>Nom et prénom</label>
                  <input
                    v-model="form.nom_prenom"
                    type="text"
                    name="nom_prenom"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('nom_prenom') }"
                  />
                  <has-error :form="form" field="nom_prenom"></has-error>
                </div>
                <!-- ///////////// -->

                <div class="form-group">
                  <label>Numéro de téléphone</label>
                  <input
                    v-model="form.num_tel"
                    type="text"
                    name="num_tel"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('num_tel') }"
                  />
                  <has-error :form="form" field="num_tel"></has-error>
                </div>

                 <div class="form-group">
                  <label for="exampleFormControlSelect1">Type</label>
                             
                 <v-select id="eleveSelect"  :class="form.errors.has('type') ? dropdownError() : '' " v-model="form.type" :options="options"></v-select>
                 <small v-show="form.errors.has('type')" style="color: red">veuillez choisir un type!</small>
                                 
                 </div>
                 <div class="form-group">
                  <label for="exampleFormControlSelect1">Année</label>
                             
                 <v-select  :class="form.errors.has('annee') ? dropdownError() : '' " v-model="form.annee" :options="optionsAnnee"></v-select>
                 <small v-show="form.errors.has('annee')" style="color: red">veuillez choisir un année!</small>
                                 
                 </div>
              </div>
              <div class="modal-footer">
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
      eleves: [],
      options: [
        'GE', 'SC', 'TM', 'LV'
      ],
      optionsAnnee: [
        '1 ére année',
        '2em année'
      ],
      form: new Form({
        id: "",
        nom_prenom: "",
        num_tel: "",
        type: "", 
        annee: ""
      })
    };
  },
  methods: {
    
    
    ///////// 
   dropdownError(){
       document.querySelector('.vs__dropdown-toggle').classList.add('alert_dropdown');
    },
    /////////////////////

    updateEleve(){

      this.form.put('/eleves/'+ this.form.id)
      .then(()=>{
              this.$Progress.start();
              Swal.fire(
                "Modifié!",
                "Eléve a été modifié avec succés",
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
                "il y a un probléme de suppression, contacter le dévloppeur!"
            });
      })
    },


    //////////////////////////////////////////////////////

    editModal(user){
      this.editMode = true;
     
          this.form.errors.clear();
       document.querySelector('#eleveSelect .vs__dropdown-toggle').classList.remove('alert_dropdown');

      this.form.reset();
          $("#modal-default").modal("show");
      this.form.fill(user);      
    },


    //////////////////////////////////////////////////////

    newModal(){
      this.editMode = false;

          this.form.errors.clear();
          this.form.reset();
          $("#modal-default").modal("show");

    },

    //////////////////////////////////////////////////////
    deleteEleve(id) {
      Swal.fire({
        title: "êtes-vous sûre?",
        text: "Vous perdez les informations sur cet éleve!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "oui, supprimer!"
      }).then(result => {
        this.form
          .delete("/eleves/" + id)
          .then(() => {
            if (result.value) {
              this.$Progress.start();

              Swal.fire(
                "Supprimé!",
                "Eléve a été supprimé avec succés",
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
    loadEleve() {
      this.$Progress.start();
      axios.get("/eleves/show/all").then(({ data }) => (this.eleves = data));
      this.$Progress.finish();
    },
//////////////////////////////////////////////////////
    createEleve() {
      this.$Progress.start();

      this.form
        .post("/eleves")
        .then(() => {
          $("#modal-default").modal("hide");
          Swal.fire("Félicitation!", "Eléve crée avec suucés!", "success");
          Fire.$emit("triggerLoad");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    }
    //////////////////////////////////////////////////////
  },
  created() {
    this.loadEleve();
    Fire.$on("triggerLoad", () => {
      this.loadEleve();
    });
  }
};
</script>
