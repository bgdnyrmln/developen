const express = require('express'); 
const app = express(); 


var name = "bogdan";
console.log(name);

app.set('view engine', 'ejs'); 
  
app.get('/:name' , (req , res)=>{ 
    res.render("index" , { 
        data : req.params.name 
    }); 
}) 
  
app.listen(4000 , ()=>{ 
    console.log("server is running on port 4000"); 
})

