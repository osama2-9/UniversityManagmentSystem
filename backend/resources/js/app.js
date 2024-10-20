const search = document.getElementById("search").value.toLowerCase();
const rows = document.querySelectorAll("#studentsTable tbody tr");

search.onchange(function (){
    rows.forEach((row)=>{
        if (row.includs(search)) {
            row.style.display = 'block'

        }else{
            row.style.display = "";
        }
    })
})

