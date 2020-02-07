<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mois {{$route.params.id_mois}}</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-tool"
                data-widget="collapse"
                data-toggle="tooltip"
                title="Collapse"
              >
                <i class="fas fa-minus"></i>
              </button>
              <button
                type="button"
                class="btn btn-tool"
                data-widget="remove"
                data-toggle="tooltip"
                title="Remove"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0" style="display: block;">
            <table class="table table-striped projects">
              <thead>
                <tr>
                  
                  <th style="width: 20%">Seances</th>
                  <th style="width: 30%">Etat</th>
                  <th>Cloturée le:</th>

                  <th style="width: 20%">Modification</th>
                </tr>
                
              </thead>
              <tbody>
                <tr  v-for="seance in seances" :key="seance.id">
               
                  <td>
                    
                    {{seance.type_seance}}
                  </td>
                  <td>
                    {{seance.cloture_date == null ? 'en attente' : seance.etat_seance}}

                  </td>

                  <td>
                    {{seance.cloture_date == null ? 'en attente' : seance.cloture_date }}
                    
                  </td>

                  <td class="project-actions">
                    <button
                      class="btn btn-success"
                      type="button"
                      @click="editModal(seance)"
                    >
                      <i class="fas fa-check-square"></i>
                      Pointer
                    </button>
                  </td>
                </tr>
            

              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Validation seance #{{form.id}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form @submit.prevent="editSeance">
            <div class="modal-body">
                <div class="form-check ">
                    <input
                    class="form-check-input form-control-lg"
                    type="radio"
                    name="etat_seance"
                    id="exampleRadios1"
                    value="A"
                    v-model="form.etat_seance"
                    />
                    <label class="form-check-label col-form-label-lg" for="exampleRadios1">Absent</label>
                </div>
                <div class="form-check">
                    <input
                    class="form-check-input form-control-lg"
                    type="radio"
                    name="etat_seance"

                    v-model="form.etat_seance"
                  
                    value="P"
                    />
                    <label class="form-check-label col-form-label-lg" for="exampleRadios2">Présent(e)</label>
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
</template>

<script>
export default {
data() {
  return {
    id: '',
    seances:[],
    form: new Form({
        id: "",
        etat_seance: ""
      })
  }
},
methods: {


    editSeance(){

      this.form.put('/seances/'+ this.form.id)
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

    //////////////////////////////////////////////////////

    editModal(seance){
     
     
          this.form.errors.clear();

      this.form.reset();
   
          $("#modal-default").modal("show");
      this.form.fill(seance);      
    },


    //////////////////////////////////////////////////////
  /////
  loadSeances(){
     this.$Progress.start();
      axios.get("/mois/"+ this.$route.params.id_mois +"/all").then(({ data }) => (this.seances = data));
      this.$Progress.finish();
  }
  
},
created() {
  
  this.loadSeances();
 Fire.$on("triggerLoad", () => {
      this.loadSeances();
    });
}
};
</script>
