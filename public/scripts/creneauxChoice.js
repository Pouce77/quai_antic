const creneauxChoice=(id)=>{
  console.log(id)
const input=document.getElementById("reservation_creneaux")
const button=document.getElementById(id)

input.value=button.value
const buttons=document.querySelectorAll(".m-1")
buttons.forEach(button => {
  button.style.backgroundColor='#839496'
});
button.style.backgroundColor='red'
console.log(input.value)
}