<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Payements</h3>

                <div class="card-tools">
                   <button type="button" class="btn btn-success" @click="newModal">
                    <i class="fas fa-money-check-alt"></i>
                  Ajouter un payement
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
                      <th>Mois</th>
                      <th>Versement</th>
                      <th>Montant totale</th>
                      <th>éffectué le</th>
                      <th>Modification</th>
                    </tr>
                  </thead>
                  <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                   
                  <td>{{ payment.id }}</td>
                     
                      <td>{{payment.eleve}}</td>
                      <td>{{payment.mois}}</td>
                      <td>{{ payment.versement }}</td>
                      <td>{{ payment.montant }}</td>
                      <td>{{ payment.created_at }}</td>
                   
                      
                      <td>
                   
                   <button @click="deletePayment(payment.id)" class="btn btn-danger">
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
              <h4 class="modal-title">Ajouter un éléve</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
             <form @submit.prevent="createPayment">
            <div class="modal-body">
            
                 <div class="form-group">

                <div class="form-group" id="eleveSelect">
                  <label for="">Eleve</label>
                 <v-select @input="updateMois(form.eleves_id)"  :class="form.errors.has('eleves_id') ? dropdownErrorEleve() : '' " v-model="form.eleves_id" :options="options_eleves" ></v-select>
                  
                </div>

                  <div class="form-group" id="moisSelect">
                  <label for="exampleFormControlSelect2">Mois</label>
                 
                 <v-select @input="updatePayment" :class="form.errors.has('eleves_id') ? dropdownErrorMois() : '' " v-model="form.mois_id" :options="options_mois"></v-select>
                  
               
                </div>
             
                   <div class="form-group">
                  <label>montant</label>
                  <input
                    v-model="form.montant"
                    type="text"
                    :disabled="montant_disable"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('montant') }"
                  />
                  <has-error :form="form" field="montant"></has-error>
                </div>

                <div class="form-group">
                  <label>versement</label>
                  <input
                    v-model="form.versement"
                    type="text"
                    
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('versement') }"
                  />
                  <has-error :form="form" field="versement"></has-error>
                </div>
                </div>
                
               
            </div>
            <div class="modal-footer ">
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
        payments: [],
       options_eleves: [],
       options_mois: [],
       montant_disable: false,

    form: new Form({
      id: "", 
      eleves_id: "",
      montant: "",
      mois_id: "",
      created_at: "", 
      versement: "", 
      eleve: "", 
      mois:""
    })
    }
  },
  methods: {


updatePayment(){
  let id = this.form.mois_id.split('-')[0];
this.form.montant= '';
 
  this.disableMontant = false;
  
  this.loadPaymentOne(id);
  

},


updateMois(id){

 
  this.loadMois(id.split('-')[0]);
  
  
},
//////////////////

loadPaymentOne(id){
this.$Progress.start();
      axios.get("/payments/"+ id).then(({ data }) => {



  Object.keys(data).forEach((val)=>{
    this.form.montant= data[val].montant
    

  });

  
  if(!this.form.montant){
  this.montant_disable = false;
  
  }else{
  this.montant_disable = true;

  }
  
 
 

      });

      this.$Progress.finish();

},
    //////////////////////////////////////////////////////
    deletePayment(id) {
      Swal.fire({
        title: "êtes-vous sûre?",
        text: "Vous perdez les informations sur ce payement!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "oui, supprimer!"
      }).then(result => {
        this.form
          .delete("/payments/" + id)
          .then(() => {
            if (result.value) {
              this.$Progress.start();

              Swal.fire(
                "Supprimé!",
                "Le payement a été supprimé avec succés",
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
loadPayments() {
      this.$Progress.start();
      axios.get("/payments/show/all").then(({ data }) => (this.payments = data));
      this.$Progress.finish();
    },
//////////////////////////////////
    createPayment(){



 this.$Progress.start();
 this.form.eleves_id = this.form.eleves_id.split('-')[0];
 this.form.mois_id = this.form.mois_id.split('-')[0];



      this.form
        .post("/payments")
        .then(() => {
          $("#modal-default").modal("hide");
          Swal.fire("Félicitation!", "Payment crée avec suucés!", "success");
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
    /////////////////////
     loadMois(id) {
      this.$Progress.start();
      axios.get("/mois/payments/"+id+"/all").then(({ data }) => {
        this.mois = data;
       
        let monthsArray = [];
        Object.keys(data).forEach((val)=>{
            
            if (!data[val]['payments_id']) {
           monthsArray.push(data[val]['id'] + '-' + data[val]['titre']);
              
            };
          
        });
        this.options_mois = monthsArray;
        
        
         

      
       
        
     });
      
     
      this.$Progress.finish();
    },
    /////////////////////////////
    dropdownErrorMois(){
       document.querySelector('#moisSelect .vs__dropdown-toggle').classList.add('alert_dropdown');
    },
     dropdownErrorEleve(){
       document.querySelector('#eleveSelect .vs__dropdown-toggle').classList.add('alert_dropdown');
    },
    /////////////////////
       //////////////////////////////////////////////////////

    newModal(){
  this.montant_disable = false;

       document.querySelector('#eleveSelect .vs__dropdown-toggle').classList.remove('alert_dropdown');
       document.querySelector('#moisSelect .vs__dropdown-toggle').classList.remove('alert_dropdown');

          this.form.errors.clear();
          this.form.reset();
          $("#modal-default").modal("show");

    },

    //////////////////////////////////////////////////////
  },
  created() {
    this.loadEleve();
    
    this.loadPayments();

 Fire.$on("triggerLoad", () => {
      this.loadPayments();
    });
       

  },
  mounted() {
     
  },
};
</script>
