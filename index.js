const express = require('express');
const app = express();
const PORT = process.env.PORT || 3000;

app.get('/',(req,res)=>{
    res.send('Hello from node.js running on Godaddy, manually configured');
});

// ...existing code...
app.listen(PORT,()=>{
    console.log(`Server is running on port ${PORT}`);
})