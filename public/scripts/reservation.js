const inputDate=document.getElementById("reservation_day")
const creneauxMatin=document.getElementById("creneauxMatin")
const creneauxAprem=document.getElementById("creneauxSoir")
const creneauxDispo=document.getElementById("creneauxDispo")
const buttonReserver=document.getElementById("buttonReserver")
let jour=""

function formatDate(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) 
      month = '0' + month;
  if (day.length < 2) 
      day = '0' + day;

  return [year, month, day].join('-');
} 

inputDate.addEventListener('change',()=>{

  const date=new Date(inputDate.value)
  jour=formatDate(date)
  
  while (creneauxMatin.firstChild) {
    creneauxMatin.removeChild(creneauxMatin.lastChild);
  }
  while(creneauxAprem.firstChild){
    creneauxAprem.removeChild(creneauxAprem.lastChild);
  }
  while(creneauxDispo.firstChild){
    creneauxDispo.removeChild(creneauxDispo.lastChild);
  }
  
  fetch("https://quai-antic.jkwebcreation.fr/reservation/".concat(jour))
  .then((res) => {
   return res.json();
  }) 
  .then(function(data) {
    
    if(data["ferme"])
    {
      let ferme=document.createElement("h3")
      ferme.textContent="Le restaurant est fermé ce jour."
      creneauxDispo.appendChild(ferme)
      buttonReserver.setAttribute("class","btn btn-primary m4 noHover")
    }else{
      buttonReserver.setAttribute("class","btn btn-primary m4")
      if(data["completM"])
      {
        let completM=document.createElement("h3")
        completM.textContent="Le restaurant est complet."
        creneauxMatin.appendChild(completM)
      }else{

        let matin = data["creneauxMatin"]
    
        for (key in matin) {
      
        let inputMatin=document.createElement("input")
        inputMatin.setAttribute("id", matin[key])
        inputMatin.setAttribute("class","btn btn-secondary m-1")
        inputMatin.setAttribute("type","button")
        inputMatin.setAttribute("onclick","creneauxChoice('"+matin[key]+"')")
        inputMatin.value=matin[key]
        creneauxMatin.appendChild(inputMatin)
        }
      }

      if(data["completA"]){
        let completA=document.createElement("h3")
        completA.textContent="Le restaurant est complet."
        creneauxAprem.appendChild(completA)
      }else{
        let aprem =data["creneauxAprem"]
        for (key in aprem) {
          let inputAprem=document.createElement("input")
          inputAprem.setAttribute("id", aprem[key])
          inputAprem.setAttribute("class","btn btn-secondary m-1")
          inputAprem.setAttribute("type","button")
          inputAprem.setAttribute("onclick","creneauxChoice('"+aprem[key]+"')")
          inputAprem.value=aprem[key]
          creneauxAprem.appendChild(inputAprem)
        }
      } 
    }
  })

  .catch(function(error) {

})
})