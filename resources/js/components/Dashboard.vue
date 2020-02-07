<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-3">
        <canvas id="myChart" width="100" height="100"></canvas>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
     
    };
  },

  methods: {
 
  },
  mounted() {

    let pourcentageData =[];

    axios.get("/eleves/pourcentage").then((response) => {
      Object.keys(response.data).map(function(key, index) {
    
          if(key == 'firstYear' || key== 'secondYear'){
              
              pourcentageData.push(response.data[key]);
          }
  
        });
        
       });
       
       console.log(pourcentageData);
       
    
    var ctx = document.getElementById("myChart");
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: ["1ére année", "2em année"],
        datasets: [
          {
            label: "Population (millions)",
            backgroundColor: [
              "#3e95cd",
              "#8e5ea2"
             
            ],
            data: pourcentageData
          }
        ]
      },
      options: {
        title: {
          display: true,
          text: "Type des éléves"
        }
      }
    });
  }
};
</script>
