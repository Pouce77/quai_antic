const inputDate=document.getElementById("choicedate")
const creneaux=document.getElementById("creneaux")
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
  
  fetch("https://127.0.0.1:8000/reservation/".concat(jour))
  .then((res) => {
   return res.json();
  }) 
  .then(function(data) {
    data.forEach(element => {
      console.log(element)
      let input=document.createElement("input")
      input.setAttribute("class","btn btn-secondary m-1 noHover")
      input.setAttribute("type","button")
      input.value=element
      creneaux.appendChild(input)
    });
  })
  .catch(function(error) {

  });

})

